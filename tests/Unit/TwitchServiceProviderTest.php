<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit;

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
        $twitchServiceProvider  = new TwitchServiceProvider($this->app);
        $provides               = $twitchServiceProvider->provides();

        $this->assertContains(TwitchApiService::class, $provides);
        $this->assertContains(TwitchOAuthService::class, $provides);
        $this->assertContains('twitch', $provides);
        $this->assertContains('twitch.oauth', $provides);
    }

    // ── boot ──────────────────────────────────────────────────────────────────

    #[Test]
    public function it_loads_routes(): void
    {
        $routes = $this->app['router']->getRoutes();

        $routeNames = array_map(
            static fn (mixed $route): ?string => is_object($route) && method_exists($route, 'getName')
                ? $route->getName()
                : null,
            iterator_to_array($routes),
        );

        $this->assertContains('twitch.auth', $routeNames);
        $this->assertContains('twitch.auth.callback', $routeNames);
        $this->assertContains('twitch.webhook', $routeNames);
    }

    #[Test]
    public function it_merges_twitch_config(): void
    {
        $this->assertNotNull(config('twitch.client_id'));
        $this->assertNotNull(config('twitch.api.base_url'));
    }

    #[Test]
    public function it_registers_twitch_alias(): void
    {
        $this->assertInstanceOf(TwitchApiService::class, $this->app->make('twitch'));
    }

    // ── register ──────────────────────────────────────────────────────────────

    #[Test]
    public function it_registers_twitch_api_service_as_singleton(): void
    {
        $twitchApiService = $this->app->make(TwitchApiService::class);
        $service2         = $this->app->make(TwitchApiService::class);

        $this->assertInstanceOf(TwitchApiService::class, $twitchApiService);
        $this->assertSame($twitchApiService, $service2);
    }

    #[Test]
    public function it_registers_twitch_oauth_alias(): void
    {
        $this->assertInstanceOf(TwitchOAuthService::class, $this->app->make('twitch.oauth'));
    }

    #[Test]
    public function it_registers_twitch_oauth_service_as_singleton(): void
    {
        $twitchOAuthService = $this->app->make(TwitchOAuthService::class);
        $service2           = $this->app->make(TwitchOAuthService::class);

        $this->assertInstanceOf(TwitchOAuthService::class, $twitchOAuthService);
        $this->assertSame($twitchOAuthService, $service2);
    }
}
