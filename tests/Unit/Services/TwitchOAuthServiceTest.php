<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionProperty;
use Zairakai\LaravelTwitch\Exceptions\TwitchApiException;
use Zairakai\LaravelTwitch\Services\TwitchOAuthService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class TwitchOAuthServiceTest extends TestCase
{
    // ── getAuthorizationUrl ───────────────────────────────────────────────────

    #[Test]
    public function it_builds_authorization_url_with_default_scopes(): void
    {
        config([
            'twitch.scopes' => [
                'user:read:email',
            ],
        ]);
        config([
            'twitch.api.auth_url' => 'https://id.twitch.tv/oauth2/',
        ]);

        $twitchOAuthService = new TwitchOAuthService(
            'client-id',
            'secret',
            'http://localhost/cb',
        );

        $url = $twitchOAuthService->getAuthorizationUrl(null, 'fixed-state');

        self::assertStringContainsString('client_id=client-id', $url);
        self::assertStringContainsString('response_type=code', $url);
        self::assertStringContainsString('state=fixed-state', $url);
        self::assertStringContainsString('scope=user%3Aread%3Aemail', $url);
    }

    #[Test]
    public function it_builds_authorization_url_with_explicit_scopes(): void
    {
        config([
            'twitch.api.auth_url' => 'https://id.twitch.tv/oauth2/',
        ]);

        $twitchOAuthService = new TwitchOAuthService(
            'client-id',
            'secret',
            'http://localhost/cb',
        );

        $url = $twitchOAuthService->getAuthorizationUrl([
            'channel:read:subscriptions',
        ], 'state-abc');

        self::assertStringContainsString('scope=channel%3Aread%3Asubscriptions', $url);
        self::assertStringContainsString('state=state-abc', $url);
    }

    // ── getAccessToken ────────────────────────────────────────────────────────

    #[Test]
    public function it_exchanges_code_for_access_token(): void
    {
        $mockHandler = new MockHandler([
            new Response(200, [], json_encode([
                'access_token'  => 'user-token-abc',
                'refresh_token' => 'refresh-abc',
                'expires_in'    => 14400,
                'scope'         => 'user:read:email channel:read:subscriptions',
                'token_type'    => 'bearer',
            ], JSON_THROW_ON_ERROR)),
        ]);

        $twitchOAuthService = $this->makeService($mockHandler);
        $result             = $twitchOAuthService->getAccessToken('auth-code-123');

        self::assertSame('user-token-abc', $result['access_token']);
        self::assertSame('refresh-abc', $result['refresh_token']);
        self::assertSame(14400, $result['expires_in']);
        self::assertSame([
            'user:read:email',
            'channel:read:subscriptions',
        ], $result['scope']);
        self::assertSame('bearer', $result['token_type']);
    }

    // ── refreshToken ──────────────────────────────────────────────────────────

    #[Test]
    public function it_refreshes_an_access_token(): void
    {
        $mockHandler = new MockHandler([
            new Response(200, [], json_encode([
                'access_token'  => 'new-token',
                'refresh_token' => 'new-refresh',
                'expires_in'    => 14400,
                'scope'         => 'user:read:email',
                'token_type'    => 'bearer',
            ], JSON_THROW_ON_ERROR)),
        ]);

        $twitchOAuthService = $this->makeService($mockHandler);
        $result             = $twitchOAuthService->refreshToken('old-refresh-token');

        self::assertSame('new-token', $result['access_token']);
        self::assertSame('new-refresh', $result['refresh_token']);
    }

    // ── base_uri resolution ──────────────────────────────────────────────────

    #[Test]
    public function it_resolves_token_against_the_configured_auth_base_uri(): void
    {
        /** @var list<array{request: RequestInterface, response: ResponseInterface|null, error: mixed, options: array<mixed>}> $history */
        $history = [];

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode([
                'access_token'  => 'tok',
                'refresh_token' => 'ref',
                'expires_in'    => 14400,
                'scope'         => 'user:read:email',
                'token_type'    => 'bearer',
            ], JSON_THROW_ON_ERROR)),
        ]);
        $handlerStack = HandlerStack::create($mockHandler);
        $handlerStack->push(Middleware::history($history));

        // Mirrors the real client construction (constructor uses config
        // 'twitch.api.auth_url' as base_uri).
        $client = new Client([
            'base_uri' => Config::string('twitch.api.auth_url'),
            'handler'  => $handlerStack,
        ]);

        $twitchOAuthService = new TwitchOAuthService(
            'client-id',
            'secret',
            'http://localhost/cb',
        );

        $reflectionProperty = new ReflectionProperty(TwitchOAuthService::class, 'client');
        $reflectionProperty->setValue($twitchOAuthService, $client);

        $twitchOAuthService->getAccessToken('auth-code');

        // RFC3986 base URI merging drops the base_uri path (`/oauth2`) when
        // the reference starts with a slash - resolves to
        // https://id.twitch.tv/token instead of .../oauth2/token otherwise,
        // a real 404 confirmed against the live Twitch endpoint.
        $entry = $history[0] ?? null;
        self::assertNotNull($entry);
        self::assertSame(
            'https://id.twitch.tv/oauth2/token',
            (string) $entry['request']->getUri(),
        );
    }

    // ── revokeToken: error path ───────────────────────────────────────────────

    #[Test]
    public function it_returns_false_when_token_revocation_fails(): void
    {
        $mockHandler = new MockHandler([
            new Response(400, [], json_encode([
                'error' => 'invalid_token',
            ], JSON_THROW_ON_ERROR)),
        ]);

        $twitchOAuthService = $this->makeService($mockHandler);

        self::assertFalse($twitchOAuthService->revokeToken('bad-token'));
    }

    // ── revokeToken ───────────────────────────────────────────────────────────

    #[Test]
    public function it_revokes_a_token_and_returns_true(): void
    {
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                '',
            ),
        ]);

        $twitchOAuthService = $this->makeService($mockHandler);

        self::assertTrue($twitchOAuthService->revokeToken('token-to-revoke'));
    }

    // ── getAccessToken: error path ────────────────────────────────────────────

    #[Test]
    public function it_throws_when_access_token_exchange_fails(): void
    {
        $mockHandler = new MockHandler([
            new Response(400, [], json_encode([
                'error' => 'invalid_grant',
            ], JSON_THROW_ON_ERROR)),
        ]);

        $twitchOAuthService = $this->makeService($mockHandler);

        $this->expectException(TwitchApiException::class);
        $twitchOAuthService->getAccessToken('bad-code');
    }

    // ── refreshToken: error path ──────────────────────────────────────────────

    #[Test]
    public function it_throws_when_token_refresh_fails(): void
    {
        $mockHandler = new MockHandler([
            new Response(401, [], json_encode([
                'error' => 'unauthorized',
            ], JSON_THROW_ON_ERROR)),
        ]);

        $twitchOAuthService = $this->makeService($mockHandler);

        $this->expectException(TwitchApiException::class);
        $twitchOAuthService->refreshToken('bad-refresh');
    }

    // ── validateToken: error path ─────────────────────────────────────────────

    #[Test]
    public function it_throws_when_token_validation_fails(): void
    {
        $mockHandler = new MockHandler([
            new Response(401, [], json_encode([
                'error' => 'unauthorized',
            ], JSON_THROW_ON_ERROR)),
        ]);

        $twitchOAuthService = $this->makeService($mockHandler);

        $this->expectException(TwitchApiException::class);
        $twitchOAuthService->validateToken('invalid-token');
    }

    // ── validateToken ─────────────────────────────────────────────────────────

    #[Test]
    public function it_validates_a_token_and_returns_payload(): void
    {
        $mockHandler = new MockHandler([
            new Response(200, [], json_encode([
                'client_id'  => 'test-client-id',
                'login'      => 'ninja',
                'scopes'     => [
                    'user:read:email',
                ],
                'user_id'    => '123',
                'expires_in' => 14400,
            ], JSON_THROW_ON_ERROR)),
        ]);

        $twitchOAuthService = $this->makeService($mockHandler);
        $result             = $twitchOAuthService->validateToken('valid-token');

        self::assertSame('ninja', $result['login']);
        self::assertSame('123', $result['user_id']);
    }

    private function makeService(MockHandler $mockHandler): TwitchOAuthService
    {
        $twitchOAuthService = new TwitchOAuthService(
            'test-client-id',
            'test-client-secret',
            'http://localhost/callback',
        );

        $client = new Client([
            'handler' => HandlerStack::create($mockHandler),
        ]);

        $reflectionProperty = new ReflectionProperty(TwitchOAuthService::class, 'client');
        $reflectionProperty->setValue($twitchOAuthService, $client);

        return $twitchOAuthService;
    }
}
