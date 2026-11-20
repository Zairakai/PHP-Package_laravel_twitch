<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;
use Zairakai\LaravelTwitch\Dto\EventSub\EventSubEventFactory;
use Zairakai\LaravelTwitch\Dto\Users\User;
use Zairakai\LaravelTwitch\Models\TwitchUser;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Services\TwitchOAuthService;

class TwitchAuthController
{
    public function __construct(
        protected TwitchOAuthService $oauth,
        protected TwitchApiService $api,
    ) {}

    /**
     * Handle OAuth callback.
     */
    public function callback(Request $request): RedirectResponse
    {
        $code         = $request->get('code');
        $state        = $request->get('state');
        $sessionState = $request->session()->pull('twitch_oauth_state');

        // Verify state parameter
        if (
            ! is_string($state)
            || $state !== $sessionState
        ) {
            return $this->failed('Invalid state parameter');
        }

        if (
            ! is_string($code)
            || '' === $code
        ) {
            return $this->failed('Authorization denied');
        }

        try {
            $user = $this->connect($code, $state);

            if (! $user instanceof TwitchUser) {
                return $this->failed('Failed to get user information');
            }

            // Store user ID in session
            $request->session()->put('twitch_user_id', $user->id);

            return $this->back()->with('success', 'Successfully connected to Twitch!');
        }
        catch (Exception $exception) {
            return $this->failed('Failed to authenticate: ' . $exception->getMessage());
        }
    }

    /**
     * Redirect to Twitch OAuth.
     */
    public function redirect(Request $request): RedirectResponse
    {
        $scopeParam = $request->get('scopes');

        /** @var array<string>|null $scopes */
        $scopes = is_array($scopeParam)
            ? $scopeParam
            : null;
        $state  = Str::random(40);
        $request->session()->put('twitch_oauth_state', $state);

        $authUrl = $this->oauth->getAuthorizationUrl($scopes, $state);

        return redirect($authUrl);
    }

    /**
     * Handle Twitch EventSub webhook.
     */
    public function webhook(Request $request): JsonResponse|Response
    {
        $signature     = $this->header($request, 'Twitch-Eventsub-Message-Signature');
        $timestamp     = $this->header($request, 'Twitch-Eventsub-Message-Timestamp');
        $messageType   = $this->header($request, 'Twitch-Eventsub-Message-Type');
        $messageId     = $this->header($request, 'Twitch-Eventsub-Message-Id');
        $headerVersion = $this->header($request, 'Twitch-Eventsub-Subscription-Version');

        // Verify webhook signature
        if (! $this->verifyWebhookSignature(
            $request->getContent(),
            $signature,
            $timestamp,
            $messageId,
        )) {
            return response()->json([
                'error' => 'Invalid signature',
            ], 400);
        }

        // The timestamp is part of what is signed: an old copy of a genuine message is a replay.
        if ($this->isTooOld($timestamp)) {
            return response()->json([
                'error' => 'Message too old',
            ], 400);
        }

        /** @var array<string, mixed> $payload */
        $payload = $request->json()->all();

        $version = $this->subscriptionVersion($headerVersion, $payload);

        // Handle webhook verification challenge - Twitch requires the raw
        // challenge string as a plain-text body, not JSON-wrapped, or the
        // subscription is marked webhook_callback_verification_failed.
        if ('webhook_callback_verification' === $messageType) {
            $challenge = $payload['challenge'] ?? '';

            return response(is_string($challenge) ? $challenge : '', 200, [
                'Content-Type' => 'text/plain',
            ]);
        }

        // Handle EventSub notifications
        if ('notification' === $messageType) {
            // Twitch delivers at least once: the same message ID can come back, and must not run twice.
            if (
                null !== $messageId
                && $this->isDuplicate($messageId)
            ) {
                return response()->json([
                    'status' => 'ok',
                ]);
            }

            $this->handleEventSubNotification($payload, $version);
        }

        // Handle EventSub revocations - found missing entirely during the
        // 2026-08-27 full doc audit (laravel-twitch#12): a revoked
        // subscription (token revoked, moderator removed, version removed,
        // too many callback failures...) used to fall through this method
        // silently, acked 200 with no log and no signal to the consuming
        // app that a trigger has gone dark.
        if ('revocation' === $messageType) {
            $this->handleEventSubRevocation($payload);
        }

        return response()->json([
            'status' => 'ok',
        ]);
    }

    /**
     * Where the application goes after the connection: `twitch.oauth.redirect_to` is a URL (it starts with `/` or
     * `http`) or the name of a route.
     */
    protected function back(): RedirectResponse
    {
        $target = config('twitch.oauth.redirect_to');

        if (
            ! is_string($target)
            || '' === $target
        ) {
            $target = 'home';
        }

        return str_starts_with($target, '/') || str_starts_with($target, 'http')
            ? redirect($target)
            : to_route($target);
    }

    /**
     * Exchange the code for a token, read the user it belongs to and create or update it.
     */
    protected function connect(string $code, string $state): ?TwitchUser
    {
        $tokenData = $this->oauth->getAccessToken($code, $state);

        /** @var string $accessToken */
        $accessToken = $tokenData['access_token'] ?? '';

        /** @var string $refreshToken */
        $refreshToken = $tokenData['refresh_token'] ?? '';

        /** @var int $expiresIn */
        $expiresIn = $tokenData['expires_in'] ?? 0;

        /** @var array<string> $scopes */
        $scopes = is_array($tokenData['scope'] ?? null)
            ? $tokenData['scope']
            : [];

        // Get user information from the authenticated user's token
        $this->api->setAccessToken($accessToken);
        $userDto = $this->api->getAuthenticatedUser();

        if (! $userDto instanceof User) {
            return null;
        }

        return TwitchUser::updateOrCreate(
            [
                'twitch_id' => $userDto->id,
            ],
            [
                'login'             => $userDto->login,
                'display_name'      => $userDto->displayName,
                'email'             => $userDto->email,
                'profile_image_url' => $userDto->profileImageUrl,
                'access_token'      => $accessToken,
                'refresh_token'     => $refreshToken,
                'expires_at'        => now()->addSeconds($expiresIn),
                'scopes'            => $scopes,
            ],
        );
    }

    protected function failed(string $message): RedirectResponse
    {
        return $this->back()->withErrors([
            'error' => $message,
        ]);
    }

    /**
     * @phpstan-assert-if-true non-empty-string $value
     */
    protected function filled(?string $value): bool
    {
        return null !== $value
            && ''   !== $value;
    }

    /**
     * Handle EventSub notification.
     *
     * Dispatches a `twitch.{type}` Laravel event carrying a typed DTO for every
     * subscription type - types without a dedicated DTO yet still get a typed
     * GenericEventSubEvent fallback, so no notification is ever silently dropped.
     *
     * Most dedicated DTOs are generated from Twitch's own documentation
     * examples rather than independently verified against real traffic
     * (flagged as such in each DTO's docblock) - Twitch's docs do not
     * reliably state which fields can be empty/null, so a wrong assumption
     * only surfaces once a real payload hits an edge case the example never
     * showed. Five such crashes were found and fixed this way
     * (laravel-twitch#13/#14/#15/#16/#17) by replaying real captured
     * traffic, and more of the ~70 still-unverified DTOs likely carry the
     * same latent bug, just not yet triggered by a real payload.
     *
     * DTO construction is therefore never allowed to crash the whole
     * webhook delivery: a `TypeError`/`ArgumentCountError` (the failure
     * mode of every bug found so far - these are `Throwable`, not
     * `Exception`, so a plain `catch (Exception)` would miss them) drops
     * only this one event and is logged loudly for triage, instead of
     * 500ing the callback - which Twitch retries and, after enough
     * failures, silently revokes the subscription entirely
     * (`notification_failures_exceeded`), killing every future event of
     * that type with no further signal.
     *
     * The listeners receive the DTO, then the version of the subscription (the payload depends on it).
     *
     * @param array<string, mixed> $payload
     * @param string|null          $version Version of the subscription type, as Twitch sent it
     *
     * @see EventSubEventFactory
     */
    protected function handleEventSubNotification(array $payload, ?string $version = null): void
    {
        $subscription = is_array($payload['subscription'] ?? null)
            ? $payload['subscription']
            : [];
        $eventType    = is_string($subscription['type'] ?? null)
            ? $subscription['type']
            : null;

        if (null === $eventType) {
            return;
        }

        // A batched type (drop.entitlement.grant) carries `events`, a list, instead of `event`.
        /** @var array<string, mixed> $eventData */
        $eventData = is_array($payload['event'] ?? null)
            ? $payload['event']
            : (is_array($payload['events'] ?? null)
                ? [
                    'events' => $payload['events'],
                ]
                : []);

        try {
            $eventSubEvent = EventSubEventFactory::make($eventType, $eventData);
        }
        catch (Throwable $throwable) {
            Log::error('Twitch EventSub notification dropped: DTO construction failed.', [
                'type'  => $eventType,
                'error' => $throwable->getMessage(),
            ]);

            event('twitch.eventsub.dto_construction_failed', [
                $eventType,
                $eventData,
                $throwable,
            ]);

            return;
        }

        event("twitch.{$eventType}", [
            $eventSubEvent,
            $version,
        ]);
    }

    /**
     * Handle EventSub revocation.
     *
     * Twitch revokes a subscription for one of four reasons: user_removed,
     * authorization_revoked, notification_failures_exceeded, or
     * version_removed. There is no dedicated DTO here (unlike
     * handleEventSubNotification) - the subscription's own type/condition
     * still identify what died precisely enough for a log line, and a
     * revocation carries no `event` payload to model in the first place.
     *
     * Always logged (the safety net every consumer gets for free) and also
     * dispatched as a Laravel event so an app that wants to react - alert,
     * mark a local record, prompt for re-auth - can listen for it.
     *
     * @param array<string, mixed> $payload
     *
     * @see https://dev.twitch.tv/docs/eventsub/handling-webhook-events/#revoking-your-subscription
     */
    protected function handleEventSubRevocation(array $payload): void
    {
        $subscription = is_array($payload['subscription'] ?? null)
            ? $payload['subscription']
            : [];

        Log::warning('Twitch EventSub subscription revoked', [
            'subscription_id'  => $subscription['id']        ?? null,
            'type'             => $subscription['type']      ?? null,
            'status'           => $subscription['status']    ?? null,
            'condition'        => $subscription['condition'] ?? null,
        ]);

        event('twitch.eventsub.revoked', [
            $subscription,
        ]);
    }

    /**
     * A header as a string, null when it is absent.
     */
    protected function header(Request $request, string $name): ?string
    {
        $value = $request->header($name);

        return is_string($value)
            ? $value
            : null;
    }

    /**
     * Whether this message ID was already handled (and remembers it otherwise).
     */
    protected function isDuplicate(string $messageId): bool
    {
        $ttl = config('twitch.eventsub.dedupe_ttl');

        if (! is_int($ttl) || 0 >= $ttl) {
            return false;
        }

        // add() only writes when the key is missing, and says whether it did.
        return ! Cache::add(
            'twitch.eventsub.message.' . $messageId,
            true,
            $ttl,
        );
    }

    /**
     * Whether a signed message is older than `twitch.eventsub.max_message_age` seconds.
     */
    protected function isTooOld(?string $timestamp): bool
    {
        $maxAge = config('twitch.eventsub.max_message_age');

        if (
            ! is_int($maxAge)
            || 0 >= $maxAge
            || null === $timestamp
        ) {
            return false;
        }

        try {
            $sentAt = Date::parse($timestamp);
        }
        catch (Throwable) {
            // Signed, so genuine: an unreadable date must not drop the event.
            return false;
        }

        return now()->getTimestamp() - $sentAt->getTimestamp() > $maxAge;
    }

    /**
     * The version of the subscription: the header when Twitch sends it, else the one of the body.
     *
     * @param array<string, mixed> $payload
     */
    protected function subscriptionVersion(?string $header, array $payload): ?string
    {
        $subscription = is_array($payload['subscription'] ?? null)
            ? $payload['subscription']
            : [];

        if (null !== $header) {
            return $header;
        }

        return is_scalar($subscription['version'] ?? null)
            ? (string) $subscription['version']
            : null;
    }

    /**
     * Verify webhook signature.
     *
     * Twitch computes the HMAC over: Message-Id + Message-Timestamp + raw body.
     *
     * @see https://dev.twitch.tv/docs/eventsub/handling-webhook-events/#verifying-the-event-message
     */
    protected function verifyWebhookSignature(
        string $body,
        ?string $signature,
        ?string $timestamp,
        ?string $messageId,
    ): bool {
        if (
            ! $this->filled($signature)
            || ! $this->filled($timestamp)
            || ! $this->filled($messageId)
        ) {
            return false;
        }

        $secret = config('twitch.eventsub.webhook_secret');

        if (
            ! is_string($secret)
            || '' === $secret
        ) {
            return false;
        }

        $expectedSignature = 'sha256=' . hash_hmac(
            'sha256',
            $messageId . $timestamp . $body,
            $secret,
        );

        return hash_equals($expectedSignature, $signature);
    }
}
