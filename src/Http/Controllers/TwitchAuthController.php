<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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
        if (! is_string($state) || $state !== $sessionState) {
            return to_route('home')->withErrors(['error' => 'Invalid state parameter']);
        }

        if (! is_string($code) || '' === $code) {
            return to_route('home')->withErrors(['error' => 'Authorization denied']);
        }

        try {
            // Exchange code for token
            $tokenData = $this->oauth->getAccessToken($code, $state);

            /** @var string $accessToken */
            $accessToken = $tokenData['access_token'] ?? '';

            /** @var string $refreshToken */
            $refreshToken = $tokenData['refresh_token'] ?? '';

            /** @var int $expiresIn */
            $expiresIn = $tokenData['expires_in'] ?? 0;

            /** @var array<string> $scopes */
            $scopes = is_array($tokenData['scope'] ?? null) ? $tokenData['scope'] : [];

            // Get user information from the authenticated user's token
            $this->api->setAccessToken($accessToken);
            $userDto = $this->api->getAuthenticatedUser();

            if (! $userDto instanceof User) {
                return to_route('home')->withErrors(['error' => 'Failed to get user information']);
            }

            // Create or update user
            $user = TwitchUser::updateOrCreate(
                ['twitch_id' => $userDto->id],
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

            // Store user ID in session
            $request->session()->put('twitch_user_id', $user->id);

            return to_route('home')->with('success', 'Successfully connected to Twitch!');
        }
        catch (Exception $exception) {
            return to_route('home')->withErrors(['error' => 'Failed to authenticate: ' . $exception->getMessage()]);
        }
    }

    /**
     * Redirect to Twitch OAuth.
     */
    public function redirect(Request $request): RedirectResponse
    {
        $scopeParam = $request->get('scopes');

        /** @var array<string>|null $scopes */
        $scopes = is_array($scopeParam) ? $scopeParam : null;
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
        // Verify webhook signature
        $headerSignature = $request->header('Twitch-Eventsub-Message-Signature');
        $headerTimestamp = $request->header('Twitch-Eventsub-Message-Timestamp');
        $headerType      = $request->header('Twitch-Eventsub-Message-Type');
        $headerMessageId = $request->header('Twitch-Eventsub-Message-Id');

        $signature   = is_string($headerSignature) ? $headerSignature : null;
        $timestamp   = is_string($headerTimestamp) ? $headerTimestamp : null;
        $messageType = is_string($headerType) ? $headerType : null;
        $messageId   = is_string($headerMessageId) ? $headerMessageId : null;

        if (! $this->verifyWebhookSignature($request->getContent(), $signature, $timestamp, $messageId)) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        /** @var array<string, mixed> $payload */
        $payload = $request->json()->all();

        // Handle webhook verification challenge - Twitch requires the raw
        // challenge string as a plain-text body, not JSON-wrapped, or the
        // subscription is marked webhook_callback_verification_failed.
        if ('webhook_callback_verification' === $messageType) {
            $rawChallenge = $payload['challenge'] ?? '';
            $challenge    = is_string($rawChallenge) ? $rawChallenge : '';

            return response($challenge, 200, ['Content-Type' => 'text/plain']);
        }

        // Handle EventSub notifications
        if ('notification' === $messageType) {
            $this->handleEventSubNotification($payload);
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

        return response()->json(['status' => 'ok']);
    }

    /**
     * Handle EventSub notification.
     *
     * Dispatches a `twitch.{type}` Laravel event carrying a typed DTO for every
     * subscription type - types without a dedicated DTO yet still get a typed
     * GenericEventSubEvent fallback, so no notification is ever silently dropped.
     *
     * @param array<string, mixed> $payload
     *
     * @see EventSubEventFactory
     */
    protected function handleEventSubNotification(array $payload): void
    {
        $subscription = is_array($payload['subscription'] ?? null) ? $payload['subscription'] : [];
        $eventType    = is_string($subscription['type'] ?? null) ? $subscription['type'] : null;

        if (null === $eventType) {
            return;
        }

        /** @var array<string, mixed> $eventData */
        $eventData = is_array($payload['event'] ?? null) ? $payload['event'] : [];

        $eventSubEvent = EventSubEventFactory::make($eventType, $eventData);

        event("twitch.{$eventType}", [$eventSubEvent]);
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
        $subscription = is_array($payload['subscription'] ?? null) ? $payload['subscription'] : [];

        Log::warning('Twitch EventSub subscription revoked', [
            'subscription_id'  => $subscription['id']        ?? null,
            'type'             => $subscription['type']      ?? null,
            'status'           => $subscription['status']    ?? null,
            'condition'        => $subscription['condition'] ?? null,
        ]);

        event('twitch.eventsub.revoked', [$subscription]);
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
        if (! $signature || ! $timestamp || ! $messageId) {
            return false;
        }

        $secret = config('twitch.eventsub.webhook_secret');

        if (! is_string($secret) || '' === $secret) {
            return false;
        }

        $expectedSignature = 'sha256=' . hash_hmac('sha256', $messageId . $timestamp . $body, $secret);

        return hash_equals($expectedSignature, $signature);
    }
}
