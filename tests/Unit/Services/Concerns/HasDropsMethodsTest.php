<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Drops\DropsEntitlement;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasDropsMethodsTest extends TestCase
{
    // ── getDropsEntitlements ──────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_entitlements_drops_endpoint(): void
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

        $service->getDropsEntitlements();

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/entitlements/drops', $capturedParams['endpoint']);
    }

    #[Test]
    public function it_returns_a_paginated_result_of_drops_entitlements(): void
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
                            'id'                 => 'ent-1',
                            'benefit_id'         => 'ben-1',
                            'user_id'            => '1',
                            'game_id'            => 'game-1',
                            'fulfillment_status' => 'CLAIMED',
                            'timestamp'          => '2024-01-01T00:00:00Z',
                        ],
                    ],
                    'pagination' => ['cursor' => 'abc123'],
                ];
            }
        };

        $paginatedResult = $service->getDropsEntitlements();

        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $this->assertCount(1, $paginatedResult->items);
        $this->assertInstanceOf(DropsEntitlement::class, $paginatedResult->items[0]);
        $this->assertSame('ent-1', $paginatedResult->items[0]->id);
        $this->assertSame('CLAIMED', $paginatedResult->items[0]->fulfillmentStatus);
    }
}
