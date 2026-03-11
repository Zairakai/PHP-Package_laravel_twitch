<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\LaravelData\LaravelDataServiceProvider;
use Zairakai\LaravelTwitch\Facades\Twitch;
use Zairakai\LaravelTwitch\Facades\TwitchOAuth;
use Zairakai\LaravelTwitch\TwitchServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadEnvironmentVariables();
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('twitch.client_id', 'test-client-id');
        $app['config']->set('twitch.client_secret', 'test-client-secret');
        $app['config']->set('twitch.redirect_uri', 'http://localhost/auth/twitch/callback');

        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Twitch'      => Twitch::class,
            'TwitchOAuth' => TwitchOAuth::class,
        ];
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelDataServiceProvider::class,
            TwitchServiceProvider::class,
        ];
    }

    private function loadEnvironmentVariables(): void
    {
        // Load any test-specific environment variables if needed
    }
}
