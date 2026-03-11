<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\HypeTrain\HypeTrain;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;
use Zairakai\LaravelTwitch\Dto\Raids\Raid;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasRaidMethodsTest extends TestCase
{
    // ── getHypeTrainEvents ────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_hypetrain_events_endpoint(): void
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

        $service->getHypeTrainEvents('1');

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/hypetrain/events', $capturedParams['endpoint']);
    }

    // ── cancelRaid ────────────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_raids_endpoint_on_cancel(): void
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

                return [];
            }
        };

        $service->cancelRaid('1');

        $this->assertSame('DELETE', $capturedParams['method']);
        $this->assertSame('/raids', $capturedParams['endpoint']);
    }

    // ── startRaid ─────────────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_raids_endpoint_on_start(): void
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

                return ['data' => [['created_at' => '2024-01-01T00:00:00Z', 'is_mature' => false]]];
            }
        };

        $service->startRaid('1', '2');

        $this->assertSame('POST', $capturedParams['method']);
        $this->assertSame('/raids', $capturedParams['endpoint']);
    }

    #[Test]
    public function it_returns_a_paginated_result_of_hype_train_events(): void
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
                            'id'                => 'ht-1',
                            'event_type'        => 'hypetrain.progression',
                            'broadcaster_id'    => '1',
                            'level'             => 1,
                            'total'             => 500,
                            'progress'          => 200,
                            'goal'              => 1000,
                            'top_contributions' => [],
                            'last_contribution' => ['total' => 100, 'type' => 'BITS', 'user' => 'test'],
                            'started_at'        => '2024-01-01T00:00:00Z',
                            'expires_at'        => '2024-01-01T01:00:00Z',
                        ],
                    ],
                    'pagination' => ['cursor' => 'abc123'],
                ];
            }
        };

        $paginatedResult = $service->getHypeTrainEvents('1');

        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $this->assertCount(1, $paginatedResult->items);
        $this->assertInstanceOf(HypeTrain::class, $paginatedResult->items[0]);
        $this->assertSame('ht-1', $paginatedResult->items[0]->id);
        $this->assertSame(1, $paginatedResult->items[0]->level);
    }

    #[Test]
    public function it_returns_a_raid_dto(): void
    {
        $service = new class('client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                return ['data' => [['created_at' => '2024-01-01T00:00:00Z', 'is_mature' => false]]];
            }
        };

        $raid = $service->startRaid('1', '2');

        $this->assertInstanceOf(Raid::class, $raid);
        $this->assertFalse($raid->isMature);
    }
}
