<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Spatie\LaravelData\DataCollection;
use Zairakai\LaravelTwitch\Dto\Conduits\Conduit;
use Zairakai\LaravelTwitch\Dto\Conduits\ConduitShard;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasConduitsMethodsTest extends TestCase
{
    // ── getConduitShards ──────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_conduit_shards_endpoint(): void
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

        $service->getConduitShards('cond-1');

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/eventsub/conduits/shards', $capturedParams['endpoint']);
    }

    // ── getConduits ───────────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_conduits_endpoint(): void
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

                return ['data' => []];
            }
        };

        $service->getConduits();

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/eventsub/conduits', $capturedParams['endpoint']);
    }

    #[Test]
    public function it_returns_a_data_collection_of_conduits(): void
    {
        $service = new class('client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                return ['data' => [['id' => 'cond-1', 'shard_count' => 5]]];
            }
        };

        $dataCollection = $service->getConduits();

        $this->assertInstanceOf(DataCollection::class, $dataCollection);
        $this->assertInstanceOf(Conduit::class, $dataCollection->first());
        $this->assertSame('cond-1', $dataCollection->first()->id);
        $this->assertSame(5, $dataCollection->first()->shardCount);
    }

    #[Test]
    public function it_returns_a_paginated_result_of_conduit_shards(): void
    {
        $service = new class('client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                return [
                    'data'       => [['id' => 'shard-1', 'status' => 'enabled']],
                    'pagination' => ['cursor' => 'abc123'],
                ];
            }
        };

        $paginatedResult = $service->getConduitShards('cond-1');

        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $this->assertCount(1, $paginatedResult->items);
        $this->assertInstanceOf(ConduitShard::class, $paginatedResult->items[0]);
        $this->assertSame('shard-1', $paginatedResult->items[0]->id);
        $this->assertSame('enabled', $paginatedResult->items[0]->status);
    }
}
