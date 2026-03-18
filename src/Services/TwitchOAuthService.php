<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TwitchOAuthService
{
    protected Client $client;

    public function __construct(
        protected string $clientId,
        protected string $clientSecret,
        protected string $redirectUri,
    ) {
        /** @var string $authUrl */
        $authUrl = config('twitch.api.auth_url');
        $timeout = is_int($t = config('twitch.api.timeout')) ? $t : 30;

        $this->client = new Client([
            'base_uri' => $authUrl,
            'timeout'  => $timeout,
        ]);
    }

    /**
     * Exchange authorization code for access token.
     *
     * @return array<string, mixed>
     */
    public function getAccessToken(string $code, ?string $state = null): array
    {
        try {
            $response = $this->client->post('/token', [
                'form_params' => [
                    'client_id'     => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'code'          => $code,
                    'grant_type'    => 'authorization_code',
                    'redirect_uri'  => $this->redirectUri,
                ],
            ]);

            /**
             * @var array{
             *     access_token: string,
             *     refresh_token: string,
             *     expires_in: int,
             *     scope: string,
             *     token_type?: string
             * } $data
             */
            $data = json_decode((string) $response->getBody(), true);

            return [
                'access_token'  => $data['access_token'],
                'refresh_token' => $data['refresh_token'],
                'expires_in'    => $data['expires_in'],
                'scope'         => explode(' ', $data['scope']),
                'token_type'    => $data['token_type'] ?? 'Bearer',
            ];
        }
        catch (RequestException $requestException) {
            Log::error('Failed to get Twitch access token', [
                'code'  => $code,
                'error' => $requestException->getMessage(),
            ]);

            throw $requestException;
        }
    }

    /**
     * Generate OAuth authorization URL.
     *
     * @param array<string>|null $scopes
     */
    public function getAuthorizationUrl(?array $scopes = null, ?string $state = null): string
    {
        if (null === $scopes) {
            $configScopes = config('twitch.scopes', []);

            /** @var array<string> $scopes */
            $scopes       = is_array($configScopes) ? $configScopes : [];
        }

        $state ??= Str::random(32);

        $params = http_build_query([
            'client_id'     => $this->clientId,
            'redirect_uri'  => $this->redirectUri,
            'response_type' => 'code',
            'scope'         => implode(' ', $scopes),
            'state'         => $state,
        ]);

        /** @var string $authUrl */
        $authUrl = config('twitch.api.auth_url');

        return $authUrl . '/authorize?' . $params;
    }

    /**
     * Refresh an access token.
     *
     * @return array<string, mixed>
     */
    public function refreshToken(string $refreshToken): array
    {
        try {
            $response = $this->client->post('/token', [
                'form_params' => [
                    'client_id'     => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'grant_type'    => 'refresh_token',
                    'refresh_token' => $refreshToken,
                ],
            ]);

            /**
             * @var array{
             *     access_token: string,
             *     refresh_token: string,
             *     expires_in: int,
             *     scope: string,
             *     token_type?: string
             * } $data
             */
            $data = json_decode((string) $response->getBody(), true);

            return [
                'access_token'  => $data['access_token'],
                'refresh_token' => $data['refresh_token'],
                'expires_in'    => $data['expires_in'],
                'scope'         => explode(' ', $data['scope']),
                'token_type'    => $data['token_type'] ?? 'Bearer',
            ];
        }
        catch (RequestException $requestException) {
            Log::error('Failed to refresh Twitch token', [
                'refresh_token' => substr($refreshToken, 0, 8) . '...',
                'error'         => $requestException->getMessage(),
            ]);

            throw $requestException;
        }
    }

    /**
     * Revoke an access token.
     */
    public function revokeToken(string $accessToken): bool
    {
        try {
            $this->client->post('/revoke', [
                'form_params' => [
                    'client_id' => $this->clientId,
                    'token'     => $accessToken,
                ],
            ]);

            return true;
        }
        catch (RequestException $requestException) {
            Log::error('Failed to revoke Twitch token', [
                'token' => substr($accessToken, 0, 8) . '...',
                'error' => $requestException->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * Validate an access token.
     *
     * @return array<string, mixed>
     */
    public function validateToken(string $accessToken): array
    {
        try {
            $response = $this->client->get('/validate', [
                'headers' => [
                    'Authorization' => 'OAuth ' . $accessToken,
                ],
            ]);

            /** @var array<string, mixed> $result */
            $result = json_decode((string) $response->getBody(), true);

            return $result;
        }
        catch (RequestException $requestException) {
            Log::error('Failed to validate Twitch token', [
                'token' => substr($accessToken, 0, 8) . '...',
                'error' => $requestException->getMessage(),
            ]);

            throw $requestException;
        }
    }
}
