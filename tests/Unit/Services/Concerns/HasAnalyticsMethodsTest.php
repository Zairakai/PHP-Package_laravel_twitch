<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Analytics\ExtensionAnalytics;
use Zairakai\LaravelTwitch\Dto\Analytics\GameAnalytics;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasAnalyticsMethodsTest extends TestCase
{
    // ── getExtensionAnalytics ─────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_extension_analytics_endpoint(): void
    {
        $capturedParams = null;

        $service = new class('client-id', 'secret', $capturedParams) extends TwitchApiService
        {
            public function __construct(
                string $clientId,
                string $clientSecret,
                public mixed &$captured,
            ) {
                parent::__construct($clientId, $clientSecret);
            }

            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                $this->captured = ['method' => $method, 'endpoint' => $endpoint, 'params' => $params];

                return ['data' => [], 'pagination' => ['cursor' => '']];
            }
        };

        $service->getExtensionAnalytics();

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/analytics/extensions', $capturedParams['endpoint']);
    }

    // ── getGameAnalytics ──────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_game_analytics_endpoint(): void
    {
        $capturedParams = null;

        $service = new class('client-id', 'secret', $capturedParams) extends TwitchApiService
        {
            public function __construct(
                string $clientId,
                string $clientSecret,
                public mixed &$captured,
            ) {
                parent::__construct($clientId, $clientSecret);
            }

            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                $this->captured = ['method' => $method, 'endpoint' => $endpoint, 'params' => $params];

                return ['data' => [], 'pagination' => ['cursor' => '']];
            }
        };

        $service->getGameAnalytics();

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/analytics/games', $capturedParams['endpoint']);
    }

    #[Test]
    public function it_returns_a_paginated_result_of_extension_analytics(): void
    {
        $service = new class('client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                return [
                    'data' => [
                        [
                            'extension_id' => 'ext-1',
                            'url'          => 'https://example.com/analytics',
                            'type'         => 'overview_v2',
                        ],
                    ],
                    'pagination' => ['cursor' => 'abc123'],
                ];
            }
        };

        $paginatedResult = $service->getExtensionAnalytics();

        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $this->assertCount(1, $paginatedResult->items);
        $this->assertInstanceOf(ExtensionAnalytics::class, $paginatedResult->items[0]);
        $this->assertSame('ext-1', $paginatedResult->items[0]->extensionId);
    }

    #[Test]
    public function it_returns_a_paginated_result_of_game_analytics(): void
    {
        $service = new class('client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                return [
                    'data' => [
                        [
                            'game_id' => 'game-1',
                            'url'     => 'https://example.com/analytics',
                            'type'    => 'overview_v2',
                        ],
                    ],
                    'pagination' => ['cursor' => 'abc123'],
                ];
            }
        };

        $paginatedResult = $service->getGameAnalytics();

        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $this->assertCount(1, $paginatedResult->items);
        $this->assertInstanceOf(GameAnalytics::class, $paginatedResult->items[0]);
        $this->assertSame('game-1', $paginatedResult->items[0]->gameId);
    }
}
