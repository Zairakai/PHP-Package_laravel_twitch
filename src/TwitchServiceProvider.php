<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch;

use Illuminate\Support\ServiceProvider;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Services\TwitchOAuthService;

class TwitchServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/twitch.php' => config_path('twitch.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        if (file_exists(__DIR__ . '/routes/twitch.php')) {
            $this->loadRoutesFrom(__DIR__ . '/routes/twitch.php');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [
            TwitchApiService::class,
            TwitchOAuthService::class,
            'twitch',
            'twitch.oauth',
        ];
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/twitch.php', 'twitch');

        $this->app->singleton(
            TwitchApiService::class,
            static function (): TwitchApiService {
                /** @var string $clientId */
                $clientId = config('twitch.client_id');

                /** @var string $clientSecret */
                $clientSecret = config('twitch.client_secret');

                return new TwitchApiService($clientId, $clientSecret);
            },
        );

        $this->app->singleton(
            TwitchOAuthService::class,
            static function (): TwitchOAuthService {
                /** @var string $clientId */
                $clientId = config('twitch.client_id');

                /** @var string $clientSecret */
                $clientSecret = config('twitch.client_secret');

                /** @var string $redirectUri */
                $redirectUri = config('twitch.redirect_uri');

                return new TwitchOAuthService($clientId, $clientSecret, $redirectUri);
            },
        );

        $this->app->alias(TwitchApiService::class, 'twitch');
        $this->app->alias(TwitchOAuthService::class, 'twitch.oauth');
    }
}
