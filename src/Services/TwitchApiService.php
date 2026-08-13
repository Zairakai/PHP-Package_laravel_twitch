<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
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
use Zairakai\LaravelTwitch\Services\Concerns\HasTagsMethods;
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
    use HasTagsMethods;
    use HasTeamsMethods;
    use HasUserMethods;

    /**
     * Date of the last Twitch API reference check.
     * Use this to detect when the upstream docs have changed.
     *
     * @see https://dev.twitch.tv/docs/api/reference
     */
    public const TWITCH_API_DOC_DATE = '2026-02-04';

    protected ?string $accessToken = null;

    protected Client $client;

    public function __construct(protected string $clientId, protected string $clientSecret)
    {
        /** @var string $baseUrl */
        $baseUrl = config('twitch.api.base_url');
        $timeout = is_int($t = config('twitch.api.timeout')) ? $t : 30;

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
            catch (RequestException $requestException) {
                Log::error('Failed to get Twitch app access token', [
                    'error' => $requestException->getMessage(),
                ]);

                throw $requestException;
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
        $ttl      = is_int($t = config('twitch.cache.ttl.game')) ? $t : 86400;

        /** @var array<string, mixed>|null */
        return Cache::remember($cacheKey, $ttl, function () use ($gameId) {
            /** @var array{data: list<array<string, mixed>>} $response */
            $response = $this->makeRequest('GET', '/games', ['id' => $gameId]);

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
        $ttl      = is_int($t = config('twitch.cache.ttl.stream')) ? $t : 300;

        /** @var array<string, mixed>|null */
        return Cache::remember($cacheKey, $ttl, function () use ($userId) {
            /** @var array{data: list<array<string, mixed>>} $response */
            $response = $this->makeRequest('GET', '/streams', ['user_id' => $userId]);

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
        $ttl      = is_int($t = config('twitch.cache.ttl.user')) ? $t : 3600;

        /** @var array<string, mixed>|null */
        return Cache::remember($cacheKey, $ttl, function () use ($identifier) {
            $params = is_numeric($identifier) ? ['id' => $identifier] : ['login' => $identifier];

            /** @var array{data: list<array<string, mixed>>} $response */
            $response = $this->makeRequest('GET', '/users', $params);

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
     * Make an authenticated API request and return the raw response body as a string.
     * Use this for endpoints that return non-JSON content (e.g. iCalendar).
     *
     * @param array<string, mixed> $params
     */
    protected function makeRawRequest(string $method, string $endpoint, array $params = []): string
    {
        $token = $this->accessToken ?? $this->getAppAccessToken();

        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Client-ID'     => $this->clientId,
            ],
        ];

        if (('GET' === $method || 'DELETE' === $method) && [] !== $params) {
            $options['query'] = $params;
        }
        elseif ([] !== $params) {
            $options['json'] = $params;
        }

        try {
            $response = $this->client->request($method, ltrim($endpoint, '/'), $options);

            return (string) $response->getBody();
        }
        catch (RequestException $requestException) {
            Log::error('Twitch API request failed', [
                'method'   => $method,
                'endpoint' => $endpoint,
                'error'    => $requestException->getMessage(),
            ]);

            throw $requestException;
        }
    }

    /**
     * Make an authenticated API request.
     *
     * @param array<string, mixed> $params
     *
     * @return array<string, mixed>
     */
    protected function makeRequest(string $method, string $endpoint, array $params = []): array
    {
        $token = $this->accessToken ?? $this->getAppAccessToken();

        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Client-ID'     => $this->clientId,
            ],
        ];

        if ('GET' === $method && [] !== $params) {
            $options['query'] = $params;
        }
        elseif ('DELETE' === $method && [] !== $params) {
            $options['query'] = $params;
        }
        elseif ([] !== $params) {
            $options['json'] = $params;
        }

        try {
            $response = $this->client->request($method, ltrim($endpoint, '/'), $options);

            if (204 === $response->getStatusCode()) {
                return [];
            }

            /** @var array<string, mixed> $result */
            $result = json_decode((string) $response->getBody(), true);

            return $result;
        }
        catch (RequestException $requestException) {
            Log::error('Twitch API request failed', [
                'method'   => $method,
                'endpoint' => $endpoint,
                'error'    => $requestException->getMessage(),
            ]);

            throw $requestException;
        }
    }
}
