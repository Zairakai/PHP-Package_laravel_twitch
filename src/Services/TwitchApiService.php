<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services;

use BadMethodCallException;
use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\TransferException;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Sleep;
use Psr\Http\Message\ResponseInterface;
use Zairakai\LaravelTwitch\Exceptions\TwitchApiException;
use Zairakai\LaravelTwitch\Services\Concerns\HasAdsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasAnalyticsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasBitsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasChannelMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasChannelPointsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasCharityMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasChatMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasConduitsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasContentLabelsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasDropsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasEventSubMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasExtensionsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasGameMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasGoalsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasGuestStarMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasModerationMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasPollMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasPredictionMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasRaidMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasStreamMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasTeamsMethods;
use Zairakai\LaravelTwitch\Services\Concerns\HasUserMethods;

class TwitchApiService
{
    use HasAdsMethods;
    use HasAnalyticsMethods;
    use HasBitsMethods;
    use HasChannelMethods;
    use HasChannelPointsMethods;
    use HasCharityMethods;
    use HasChatMethods;
    use HasConduitsMethods;
    use HasContentLabelsMethods;
    use HasDropsMethods;
    use HasEventSubMethods;
    use HasExtensionsMethods;
    use HasGameMethods;
    use HasGoalsMethods;
    use HasGuestStarMethods;
    use HasModerationMethods;
    use HasPollMethods;
    use HasPredictionMethods;
    use HasRaidMethods;
    use HasStreamMethods;
    use HasTeamsMethods;
    use HasUserMethods;

    /**
     * Date of the last Twitch API reference check.
     * Use this to detect when the upstream docs have changed.
     *
     * @see https://dev.twitch.tv/docs/api/reference
     */
    public const TWITCH_API_DOC_DATE = '2026-02-04';

    /**
     * Longest wait for a rate limit, in milliseconds: beyond it the 429 is thrown instead of blocking the request.
     */
    private const int MAX_RATE_LIMIT_WAIT_MS = 10_000;

    protected ?string $accessToken = null;

    protected Client $client;

    /**
     * @var (Closure(): (string|null))|null
     */
    private ?Closure $tokenRefresher = null;

    public function __construct(protected string $clientId, protected string $clientSecret)
    {
        /** @var string $baseUrl */
        $baseUrl = config('twitch.api.base_url');
        $timeout = is_int($t = config('twitch.api.timeout'))
            ? $t
            : 30;

        $this->client = new Client([
            'base_uri' => $baseUrl,
            'timeout'  => $timeout,
            'headers'  => [
                'Client-ID'    => $this->clientId,
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    /**
     * Get app access token for client credentials flow.
     * Cached for 1 hour to avoid excessive token requests.
     */
    public function getAppAccessToken(): string
    {
        $cacheKey = 'twitch.app_access_token';

        /** @var string */
        return Cache::remember($cacheKey, 3600, function () {
            try {
                $response = $this->client->post('https://id.twitch.tv/oauth2/token', [
                    'form_params' => [
                        'client_id'     => $this->clientId,
                        'client_secret' => $this->clientSecret,
                        'grant_type'    => 'client_credentials',
                    ],
                ]);

                /** @var array{access_token: string} $data */
                $data = json_decode((string) $response->getBody(), true);

                return $data['access_token'];
            }
            catch (TransferException $transferException) {
                Log::error('Failed to get Twitch app access token', [
                    'error' => $transferException->getMessage(),
                ]);

                throw TwitchApiException::from($transferException);
            }
        });
    }

    /**
     * Get game information by ID (with caching).
     *
     * @return array<string, mixed>|null
     */
    public function getGame(string $gameId): ?array
    {
        $cacheKey = "twitch.game.{$gameId}";
        $ttl      = is_int($t = config('twitch.cache.ttl.game'))
            ? $t
            : 86400;

        /** @var array<string, mixed>|null */
        return $this->remember($cacheKey, $ttl, function () use ($gameId) {
            /** @var array{data: list<array<string, mixed>>} $response */
            $response = $this->makeRequest('GET', '/games', [
                'id' => $gameId,
            ]);

            return $response['data'][0] ?? null;
        });
    }

    /**
     * Get stream information by user ID (with caching).
     *
     * @return array<string, mixed>|null
     */
    public function getStream(string $userId): ?array
    {
        $cacheKey = "twitch.stream.{$userId}";
        $ttl      = is_int($t = config('twitch.cache.ttl.stream'))
            ? $t
            : 300;

        /** @var array<string, mixed>|null */
        return $this->remember($cacheKey, $ttl, function () use ($userId) {
            /** @var array{data: list<array<string, mixed>>} $response */
            $response = $this->makeRequest('GET', '/streams', [
                'user_id' => $userId,
            ]);

            return $response['data'][0] ?? null;
        });
    }

    /**
     * Get user information by username or ID (with caching).
     *
     * @return array<string, mixed>|null
     */
    public function getUser(int|string $identifier): ?array
    {
        $cacheKey = "twitch.user.{$identifier}";
        $ttl      = is_int($t = config('twitch.cache.ttl.user'))
            ? $t
            : 3600;

        /** @var array<string, mixed>|null */
        return $this->remember($cacheKey, $ttl, function () use ($identifier) {
            $params = is_numeric($identifier)
                ? [
                    'id' => $identifier,
                ]
                : [
                    'login' => $identifier,
                ];

            /** @var array{data: list<array<string, mixed>>} $response */
            $response = $this->makeRequest(
                'GET',
                '/users',
                $params,
            );

            return $response['data'][0] ?? null;
        });
    }

    /**
     * Set the user access token for authenticated requests.
     * Call this before making requests that require user context.
     */
    public function setAccessToken(string $token): self
    {
        $this->accessToken = $token;

        return $this;
    }

    /**
     * Give the service a way to get a new user access token when Twitch answers 401.
     *
     * Twitch advises refreshing reactively, on a 401, not ahead of the expiry. The callback returns the new access
     * token (after using the refresh token), or null to give up. The request is then sent once more with it.
     *
     * @param (callable(): (string|null))|null $refresher
     */
    public function setTokenRefresher(?callable $refresher): self
    {
        $this->tokenRefresher = null === $refresher
            ? null
            : $refresher(...);

        return $this;
    }

    /**
     * A GET whose answer is cached for the number of seconds of `twitch.cache.ttl.<ttlKey>` (unless the cache is off).
     * Only for answers that do not depend on the token: the same call gives the same answer to everyone.
     *
     * @param array<string, mixed> $params
     *
     * @return array<string, mixed>
     */
    protected function makeCachedRequest(
        string $ttlKey,
        string $endpoint,
        array $params = [],
    ): array {
        $ttl = config('twitch.cache.ttl.' . $ttlKey);

        /** @var array<string, mixed> */
        return $this->remember(
            'twitch.' . $ttlKey . '.' . md5($endpoint . json_encode($params)),
            is_int($ttl) ? $ttl : 3600,
            fn (): array => $this->makeRequest(
                'GET',
                $endpoint,
                $params,
            ),
        );
    }

    /**
     * Make an authenticated API request that needs BOTH query string and
     * JSON body params at once - Send Whisper is the one endpoint in the
     * package that does (from_user_id/to_user_id as query, message as
     * body), confirmed against Twitch's own docs (2026-08-27). Every other
     * request shape needs at most one or the other, hence makeRequest()/
     * makeQueryRequest() only ever populate a single Guzzle option key.
     *
     * @param array<string, mixed> $queryParams
     * @param array<string, mixed> $bodyParams
     *
     * @return array<string, mixed>
     */
    protected function makeQueryAndBodyRequest(
        string $method,
        string $endpoint,
        array $queryParams,
        array $bodyParams = [],
    ): array {
        $options = [];

        if ([] !== $queryParams) {
            $options['query'] = $queryParams;
        }

        if ([] !== $bodyParams) {
            $options['json'] = $bodyParams;
        }

        return $this->decode($this->send(
            $method,
            $endpoint,
            $options,
        ));
    }

    /**
     * Make an authenticated API request whose params always belong in the
     * query string, regardless of HTTP method - a handful of Twitch
     * endpoints take their identifying parameters (broadcaster_id,
     * moderator_id, message_id, ...) as query params even on a
     * PUT/PATCH/DELETE, e.g. Pin/Update Pinned/Unpin Chat Message, Update
     * User Chat Color. makeRequest() only ever sends query params for
     * GET/DELETE.
     *
     * A separate method rather than a new parameter on makeRequest(): PHP
     * requires an overriding method's signature to be a superset of the
     * parent's, so adding a parameter there would break every test double
     * across the suite that overrides makeRequest() with its current
     * 3-parameter signature.
     *
     * @param array<string, mixed> $params
     *
     * @return array<string, mixed>
     */
    protected function makeQueryRequest(
        string $method,
        string $endpoint,
        array $params = [],
    ): array {
        return $this->decode($this->send($method, $endpoint, [] === $params ? [] : [
            'query' => $params,
        ]));
    }

    /**
     * Make an authenticated API request and return the raw response body as a string.
     * Use this for endpoints that return non-JSON content (e.g. iCalendar).
     *
     * @param array<string, mixed> $params
     */
    protected function makeRawRequest(
        string $method,
        string $endpoint,
        array $params = [],
    ): string {
        return (string) $this->send(
            $method,
            $endpoint,
            $this->optionsFor($method, $params),
        )->getBody();
    }

    /**
     * Make an authenticated API request.
     *
     * @param array<string, mixed> $params
     *
     * @return array<string, mixed>
     */
    protected function makeRequest(
        string $method,
        string $endpoint,
        array $params = [],
    ): array {
        return $this->decode($this->send(
            $method,
            $endpoint,
            $this->optionsFor($method, $params),
        ));
    }

    /**
     * @return array<string, mixed>
     */
    private function decode(ResponseInterface $response): array
    {
        if (204 === $response->getStatusCode()) {
            return [];
        }

        /** @var array<string, mixed> $result */
        $result = json_decode((string) $response->getBody(), true);

        return $result;
    }

    private function maxRateLimitRetries(): int
    {
        $times = config('twitch.api.retry.times');

        return is_int($times)
            ? max(0, $times)
            : 0;
    }

    /**
     * GET and DELETE carry their params in the query string, the other methods in a JSON body.
     *
     * @param array<string, mixed> $params
     *
     * @return array{query?: array<string, mixed>, json?: array<string, mixed>}
     */
    private function optionsFor(string $method, array $params): array
    {
        if ([] === $params) {
            return [];
        }

        return 'GET' === $method || 'DELETE' === $method
            ? [
                'query' => $params,
            ]
            : [
                'json' => $params,
            ];
    }

    /**
     * Cache the answer of a call for `$ttl` seconds, unless `twitch.cache.enabled` is false.
     *
     * @template T
     *
     * @param Closure(): T $callback
     *
     * @return T
     */
    private function remember(
        string $key,
        int $ttl,
        callable $callback,
    ): mixed {
        return false === config('twitch.cache.enabled', true)
            ? $callback()
            : Cache::remember(
                $key,
                $ttl,
                $callback,
            );
    }

    /**
     * Get a new token after a 401: forget the cached app token, or ask the refresher for a new user token.
     */
    private function renewToken(): bool
    {
        if (null === $this->accessToken) {
            Cache::forget('twitch.app_access_token');

            return true;
        }

        if (! $this->tokenRefresher instanceof Closure) {
            return false;
        }

        $token = ($this->tokenRefresher)();

        if (
            ! is_string($token)
            || ''     === $token
            || $token === $this->accessToken
        ) {
            return false;
        }

        $this->accessToken = $token;

        return true;
    }

    /**
     * A 401 is retried once with a renewed token, a 429 as many times as `twitch.api.retry.times` allows.
     */
    private function retryAfterFailure(
        ?int $status,
        TransferException $requestException,
        bool &$renewed,
        int &$rateRetries,
    ): bool {
        if (
            401 === $status
            && ! $renewed
            && $this->renewToken()
        ) {
            $renewed = true;

            return true;
        }

        if (
            429 === $status
            && $this->maxRateLimitRetries() > $rateRetries
            && $this->waitForRateLimit($requestException)
        ) {
            $rateRetries++;

            return true;
        }

        return false;
    }

    /**
     * Send a request with the current token, and once more after a 401 (new token) or a few times after a 429
     * (rate limit: waits until Twitch says the limit is reset).
     *
     * @param array{query?: array<string, mixed>, json?: array<string, mixed>} $options Guzzle options, without the headers
     */
    private function send(
        string $method,
        string $endpoint,
        array $options,
    ): ResponseInterface {
        $renewed     = false;
        $rateRetries = 0;

        while (true) {
            $this->throttle();

            $options['headers'] = [
                'Authorization' => 'Bearer ' . ($this->accessToken ?? $this->getAppAccessToken()),
                'Client-ID'     => $this->clientId,
            ];

            try {
                return $this->client->request(
                    $method,
                    ltrim($endpoint, '/'),
                    $options,
                );
            }
            catch (TransferException $requestException) {
                $status = $requestException instanceof BadResponseException
                    ? $requestException->getResponse()->getStatusCode()
                    : null;

                if ($this->retryAfterFailure(
                    $status,
                    $requestException,
                    $renewed,
                    $rateRetries,
                )) {
                    continue;
                }

                Log::error('Twitch API request failed', [
                    'method'   => $method,
                    'endpoint' => $endpoint,
                    'error'    => $requestException->getMessage(),
                ]);

                throw TwitchApiException::from($requestException);
            }
        }
    }

    /**
     * Take one call from the bucket. Returns 0 when it was taken, else the milliseconds to wait for the next one.
     * Without a cache that can lock, the calls are not limited.
     */
    private function takeToken(
        string $key,
        float $perSecond,
        int $burst,
    ): int {
        try {
            $wait = Cache::lock($key . '.lock', 5)->block(5, function () use ($key, $perSecond, $burst): int {
                $now   = (float) Date::now()->format('U.u');
                $state = Cache::get($key);
                $last  = is_array($state) && is_float($state['at'] ?? null)
                    ? $state['at']
                    : $now;
                $held  = is_array($state) && is_float($state['tokens'] ?? null)
                    ? $state['tokens']
                    : (float) $burst;
                $held  = min((float) $burst, $held + ($now - $last) * $perSecond);

                $taken = 1.0 <= $held;

                Cache::put($key, [
                    'tokens' => $taken ? $held - 1 : $held,
                    'at'     => $now,
                ], 120);

                return $taken
                    ? 0
                    : (int) ceil((1 - $held) / $perSecond * 1000);
            });

            return is_int($wait)
                ? $wait
                : 0;
        }
        catch (LockTimeoutException|BadMethodCallException) {
            return 0;
        }
    }

    /**
     * Keep the calls under `twitch.rate_limit`: a token bucket of `burst_limit` calls, refilled at
     * `requests_per_minute` per minute. The bucket is in the cache, so every process of the application shares it
     * (it is per client ID: Twitch gives each app 800 points per minute). Waits when the bucket is empty.
     */
    private function throttle(): void
    {
        $perMinute = config('twitch.rate_limit.requests_per_minute');
        $burst     = config('twitch.rate_limit.burst_limit');

        if (
            false === config('twitch.rate_limit.enabled', true)
            || ! is_int($perMinute)
            || ! is_int($burst)
            || 0 >= $perMinute
            || 0 >= $burst
        ) {
            return;
        }

        $key = 'twitch.rate_limit.' . $this->clientId;

        for ($attempt = 0; 100 > $attempt; $attempt++) {
            $wait = $this->takeToken(
                $key,
                $perMinute / 60,
                $burst,
            );

            if (0 === $wait) {
                return;
            }

            Sleep::for($wait)->milliseconds();
        }
    }

    /**
     * Wait for the rate limit to reset: until `Ratelimit-Reset` (a Unix time) when Twitch gives it, else
     * `twitch.api.retry.sleep` milliseconds. Gives up (false) when the wait would be longer than 10 seconds.
     */
    private function waitForRateLimit(TransferException $requestException): bool
    {
        $reset = $requestException instanceof BadResponseException
            ? $requestException->getResponse()->getHeaderLine('Ratelimit-Reset')
            : '';

        if (ctype_digit($reset)) {
            $milliseconds = max(0, ((int) $reset - time()) * 1000) + 100;
        }
        else {
            $sleep        = config('twitch.api.retry.sleep');
            $milliseconds = is_int($sleep)
                ? $sleep
                : 500;
        }

        if (self::MAX_RATE_LIMIT_WAIT_MS < $milliseconds) {
            return false;
        }

        Sleep::for($milliseconds)->milliseconds();

        return true;
    }
}
