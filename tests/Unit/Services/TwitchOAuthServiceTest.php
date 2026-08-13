<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\RequestInterface;
use ReflectionProperty;
use Zairakai\LaravelTwitch\Services\TwitchOAuthService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class TwitchOAuthServiceTest extends TestCase
{
    // ── getAuthorizationUrl ───────────────────────────────────────────────────

    #[Test]
    public function it_builds_authorization_url_with_default_scopes(): void
    {
        $this->app['config']->set('twitch.scopes', ['user:read:email']);
        $this->app['config']->set('twitch.api.auth_url', 'https://id.twitch.tv/oauth2/');

        $twitchOAuthService = new TwitchOAuthService('client-id', 'secret', 'http://localhost/cb');

        $url = $twitchOAuthService->getAuthorizationUrl(null, 'fixed-state');

        $this->assertStringContainsString('client_id=client-id', $url);
        $this->assertStringContainsString('response_type=code', $url);
        $this->assertStringContainsString('state=fixed-state', $url);
        $this->assertStringContainsString('scope=user%3Aread%3Aemail', $url);
    }

    #[Test]
    public function it_builds_authorization_url_with_explicit_scopes(): void
    {
        $this->app['config']->set('twitch.api.auth_url', 'https://id.twitch.tv/oauth2/');

        $twitchOAuthService = new TwitchOAuthService('client-id', 'secret', 'http://localhost/cb');

        $url = $twitchOAuthService->getAuthorizationUrl(['channel:read:subscriptions'], 'state-abc');

        $this->assertStringContainsString('scope=channel%3Aread%3Asubscriptions', $url);
        $this->assertStringContainsString('state=state-abc', $url);
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
            ])),
        ]);

        $twitchOAuthService = $this->makeService($mockHandler);
        $result             = $twitchOAuthService->getAccessToken('auth-code-123');

        $this->assertSame('user-token-abc', $result['access_token']);
        $this->assertSame('refresh-abc', $result['refresh_token']);
        $this->assertSame(14400, $result['expires_in']);
        $this->assertSame(['user:read:email', 'channel:read:subscriptions'], $result['scope']);
        $this->assertSame('bearer', $result['token_type']);
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
            ])),
        ]);

        $twitchOAuthService = $this->makeService($mockHandler);
        $result             = $twitchOAuthService->refreshToken('old-refresh-token');

        $this->assertSame('new-token', $result['access_token']);
        $this->assertSame('new-refresh', $result['refresh_token']);
    }

    // ── base_uri resolution ──────────────────────────────────────────────────

    #[Test]
    public function it_resolves_token_against_the_configured_auth_base_uri(): void
    {
        /** @var array<int, array{request: RequestInterface}> $history */
        $history = [];

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode([
                'access_token'  => 'tok',
                'refresh_token' => 'ref',
                'expires_in'    => 14400,
                'scope'         => 'user:read:email',
                'token_type'    => 'bearer',
            ])),
        ]);
        $handlerStack = HandlerStack::create($mockHandler);
        $handlerStack->push(Middleware::history($history));

        // Mirrors the real client construction (constructor uses config
        // 'twitch.api.auth_url' as base_uri).
        $client = new Client([
            'base_uri' => config('twitch.api.auth_url'),
            'handler'  => $handlerStack,
        ]);

        $twitchOAuthService = new TwitchOAuthService('client-id', 'secret', 'http://localhost/cb');

        $reflectionProperty = new ReflectionProperty(TwitchOAuthService::class, 'client');
        $reflectionProperty->setValue($twitchOAuthService, $client);

        $twitchOAuthService->getAccessToken('auth-code');

        // RFC3986 base URI merging drops the base_uri path (`/oauth2`) when
        // the reference starts with a slash - resolves to
        // https://id.twitch.tv/token instead of .../oauth2/token otherwise,
        // a real 404 confirmed against the live Twitch endpoint.
        $this->assertSame(
            'https://id.twitch.tv/oauth2/token',
            (string) $history[0]['request']->getUri(),
        );
    }

    // ── revokeToken: error path ───────────────────────────────────────────────

    #[Test]
    public function it_returns_false_when_token_revocation_fails(): void
    {
        $mockHandler = new MockHandler([
            new Response(400, [], json_encode(['error' => 'invalid_token'])),
        ]);

        $twitchOAuthService = $this->makeService($mockHandler);

        $this->assertFalse($twitchOAuthService->revokeToken('bad-token'));
    }

    // ── revokeToken ───────────────────────────────────────────────────────────

    #[Test]
    public function it_revokes_a_token_and_returns_true(): void
    {
        $mockHandler = new MockHandler([
            new Response(200, [], ''),
        ]);

        $twitchOAuthService = $this->makeService($mockHandler);

        $this->assertTrue($twitchOAuthService->revokeToken('token-to-revoke'));
    }

    // ── getAccessToken: error path ────────────────────────────────────────────

    #[Test]
    public function it_throws_when_access_token_exchange_fails(): void
    {
        $mockHandler = new MockHandler([
            new Response(400, [], json_encode(['error' => 'invalid_grant'])),
        ]);

        $twitchOAuthService = $this->makeService($mockHandler);

        $this->expectException(RequestException::class);
        $twitchOAuthService->getAccessToken('bad-code');
    }

    // ── refreshToken: error path ──────────────────────────────────────────────

    #[Test]
    public function it_throws_when_token_refresh_fails(): void
    {
        $mockHandler = new MockHandler([
            new Response(401, [], json_encode(['error' => 'unauthorized'])),
        ]);

        $twitchOAuthService = $this->makeService($mockHandler);

        $this->expectException(RequestException::class);
        $twitchOAuthService->refreshToken('bad-refresh');
    }

    // ── validateToken: error path ─────────────────────────────────────────────

    #[Test]
    public function it_throws_when_token_validation_fails(): void
    {
        $mockHandler = new MockHandler([
            new Response(401, [], json_encode(['error' => 'unauthorized'])),
        ]);

        $twitchOAuthService = $this->makeService($mockHandler);

        $this->expectException(RequestException::class);
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
                'scopes'     => ['user:read:email'],
                'user_id'    => '123',
                'expires_in' => 14400,
            ])),
        ]);

        $twitchOAuthService = $this->makeService($mockHandler);
        $result             = $twitchOAuthService->validateToken('valid-token');

        $this->assertSame('ninja', $result['login']);
        $this->assertSame('123', $result['user_id']);
    }

    private function makeService(MockHandler $mockHandler): TwitchOAuthService
    {
        $twitchOAuthService = new TwitchOAuthService(
            'test-client-id',
            'test-client-secret',
            'http://localhost/callback',
        );

        $client = new Client(['handler' => HandlerStack::create($mockHandler)]);

        $reflectionProperty = new ReflectionProperty(TwitchOAuthService::class, 'client');
        $reflectionProperty->setValue($twitchOAuthService, $client);

        return $twitchOAuthService;
    }
}
