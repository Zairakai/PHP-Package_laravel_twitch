<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Spatie\LaravelData\DataCollection;
use Zairakai\LaravelTwitch\Dto\Bits\BitsLeaderboardEntry;
use Zairakai\LaravelTwitch\Dto\Bits\Cheermote;
use Zairakai\LaravelTwitch\Dto\Bits\CustomPowerUp;
use Zairakai\LaravelTwitch\Dto\Bits\ExtensionTransaction;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasBitsMethodsTest extends TestCase
{
    // ── getBitsLeaderboard ────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_bits_leaderboard_endpoint(): void
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

        $service->getBitsLeaderboard();

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/bits/leaderboard', $capturedParams['endpoint']);
    }

    // ── getCheermotes ─────────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_cheermotes_endpoint(): void
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

        $service->getCheermotes();

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/bits/cheermotes', $capturedParams['endpoint']);
    }

    // ── getCustomPowerUps ─────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_custom_power_ups_endpoint(): void
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

        $service->getCustomPowerUps('12345');

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/bits/custom_power_ups', $capturedParams['endpoint']);
        $this->assertSame('12345', $capturedParams['params']['broadcaster_id']);
    }

    // ── getExtensionTransactions ──────────────────────────────────────────────

    #[Test]
    public function it_calls_the_extension_transactions_endpoint(): void
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

        $service->getExtensionTransactions('ext-1');

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/extensions/transactions', $capturedParams['endpoint']);
    }

    #[Test]
    public function it_returns_a_data_collection_of_bits_leaderboard_entries(): void
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
                            'user_id'    => '1',
                            'user_login' => 'test',
                            'user_name'  => 'Test',
                            'score'      => 100,
                            'rank'       => 1,
                        ],
                    ],
                ];
            }
        };

        $dataCollection = $service->getBitsLeaderboard();

        $this->assertInstanceOf(DataCollection::class, $dataCollection);
        $this->assertInstanceOf(BitsLeaderboardEntry::class, $dataCollection->first());
        $this->assertSame('1', $dataCollection->first()->userId);
        $this->assertSame(100, $dataCollection->first()->score);
    }

    #[Test]
    public function it_returns_a_data_collection_of_cheermotes(): void
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
                            'prefix'        => 'Cheer',
                            'tiers'         => [],
                            'type'          => 'global_first_party',
                            'order'         => 1,
                            'last_updated'  => '2024-01-01T00:00:00Z',
                            'is_charitable' => false,
                        ],
                    ],
                ];
            }
        };

        $dataCollection = $service->getCheermotes();

        $this->assertInstanceOf(DataCollection::class, $dataCollection);
        $this->assertInstanceOf(Cheermote::class, $dataCollection->first());
        $this->assertSame('Cheer', $dataCollection->first()->prefix);
    }

    #[Test]
    public function it_returns_a_data_collection_of_custom_power_ups(): void
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
                            'broadcaster_id'         => '12345',
                            'broadcaster_login'      => 'streamer',
                            'broadcaster_name'       => 'Streamer',
                            'id'                     => 'power-up-1',
                            'title'                  => 'Confetti',
                            'prompt'                 => 'Rain confetti on screen',
                            'bits'                   => 500,
                            'background_color'       => '#FA1ED2',
                            'is_enabled'             => true,
                            'is_user_input_required' => false,
                            'is_paused'              => false,
                            'is_in_stock'            => true,
                        ],
                    ],
                ];
            }
        };

        $dataCollection = $service->getCustomPowerUps('12345');

        $this->assertInstanceOf(DataCollection::class, $dataCollection);
        $this->assertInstanceOf(CustomPowerUp::class, $dataCollection->first());
        $this->assertSame('power-up-1', $dataCollection->first()->id);
        $this->assertSame(500, $dataCollection->first()->bits);
    }

    #[Test]
    public function it_returns_a_paginated_result_of_extension_transactions(): void
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
                            'id'                => 'tx-1',
                            'timestamp'         => '2024-01-01T00:00:00Z',
                            'broadcaster_id'    => '1',
                            'broadcaster_login' => 'test',
                            'broadcaster_name'  => 'Test',
                            'user_id'           => '2',
                            'user_login'        => 'user',
                            'user_name'         => 'User',
                            'product_type'      => 'BITS_IN_EXTENSION',
                            'product_data'      => [],
                        ],
                    ],
                    'pagination' => ['cursor' => 'abc123'],
                ];
            }
        };

        $paginatedResult = $service->getExtensionTransactions('ext-1');

        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $this->assertCount(1, $paginatedResult->items);
        $this->assertInstanceOf(ExtensionTransaction::class, $paginatedResult->items[0]);
        $this->assertSame('tx-1', $paginatedResult->items[0]->id);
    }
}
