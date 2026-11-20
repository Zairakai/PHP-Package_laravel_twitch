<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit;

use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Services\TwitchOAuthService;
use Zairakai\LaravelTwitch\Tests\TestCase;
use Zairakai\LaravelTwitch\TwitchServiceProvider;

final class TwitchServiceProviderTest extends TestCase
{
    // ── provides ──────────────────────────────────────────────────────────────

    #[Test]
    public function it_declares_provided_services(): void
    {
        $twitchServiceProvider  = new TwitchServiceProvider(app());
        $provides               = $twitchServiceProvider->provides();

        self::assertContains(TwitchApiService::class, $provides);
        self::assertContains(TwitchOAuthService::class, $provides);
        self::assertContains('twitch', $provides);
        self::assertContains('twitch.oauth', $provides);
    }

    // ── boot ──────────────────────────────────────────────────────────────────

    #[Test]
    public function it_loads_routes(): void
    {
        $routeNames = array_map(
            static fn (Route $route): ?string => $route->getName(),
            resolve(Router::class)->getRoutes()->getRoutes(),
        );

        self::assertContains('twitch.auth', $routeNames);
        self::assertContains('twitch.auth.callback', $routeNames);
        self::assertContains('twitch.webhook', $routeNames);
    }

    #[Test]
    public function it_merges_twitch_config(): void
    {
        self::assertNotNull(config('twitch.client_id'));
        self::assertNotNull(config('twitch.api.base_url'));
    }

    #[Test]
    public function it_registers_twitch_alias(): void
    {
        self::assertInstanceOf(TwitchApiService::class, resolve('twitch'));
    }

    // ── register ──────────────────────────────────────────────────────────────

    #[Test]
    public function it_registers_twitch_api_service_as_singleton(): void
    {
        $twitchApiService = resolve(TwitchApiService::class);
        $service2         = resolve(TwitchApiService::class);

        self::assertInstanceOf(TwitchApiService::class, $twitchApiService);
        self::assertSame($twitchApiService, $service2);
    }

    #[Test]
    public function it_registers_twitch_oauth_alias(): void
    {
        self::assertInstanceOf(TwitchOAuthService::class, resolve('twitch.oauth'));
    }

    #[Test]
    public function it_registers_twitch_oauth_service_as_singleton(): void
    {
        $twitchOAuthService = resolve(TwitchOAuthService::class);
        $service2           = resolve(TwitchOAuthService::class);

        self::assertInstanceOf(TwitchOAuthService::class, $twitchOAuthService);
        self::assertSame($twitchOAuthService, $service2);
    }
}
