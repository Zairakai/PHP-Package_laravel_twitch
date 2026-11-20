<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Services\TwitchOAuthService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class TwitchOAuthServiceTest extends TestCase
{
    private TwitchOAuthService $twitchOAuthService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->twitchOAuthService = new TwitchOAuthService(
            'test-client-id',
            'test-client-secret',
            'http://localhost/auth/twitch/callback',
        );
    }

    #[Test]
    public function it_generates_authorization_url(): void
    {
        $url = $this->twitchOAuthService->getAuthorizationUrl([
            'user:read:email',
        ], 'test-state');

        self::assertStringContainsString('https://id.twitch.tv/oauth2/authorize', $url);
        self::assertStringContainsString('client_id=test-client-id', $url);
        self::assertStringContainsString('scope=user%3Aread%3Aemail', $url);
        self::assertStringContainsString('state=test-state', $url);
    }

    #[Test]
    public function it_generates_authorization_url_with_default_scopes(): void
    {
        config([
            'twitch.scopes' => [
                'user:read:email',
                'channel:read:subscriptions',
            ],
        ]);

        $url = $this->twitchOAuthService->getAuthorizationUrl();

        self::assertStringContainsString('scope=user%3Aread%3Aemail+channel%3Aread%3Asubscriptions', $url);
    }

    #[Test]
    public function it_has_required_constructor_parameters(): void
    {
        $twitchOAuthService = new TwitchOAuthService(
            'client-id',
            'client-secret',
            'redirect-uri',
        );

        $url = $twitchOAuthService->getAuthorizationUrl([
            'user:read:email',
        ], 'test-state');

        self::assertStringContainsString('client_id=client-id', $url);
        self::assertStringContainsString('redirect_uri=redirect-uri', $url);
    }
}
