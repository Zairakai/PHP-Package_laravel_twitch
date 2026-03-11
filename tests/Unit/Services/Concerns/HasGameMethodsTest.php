<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Spatie\LaravelData\DataCollection;
use Zairakai\LaravelTwitch\Dto\Games\Game;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasGameMethodsTest extends TestCase
{
    // ── getGames ──────────────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_games_endpoint(): void
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

        $service->getGames(ids: ['game-1']);

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/games', $capturedParams['endpoint']);
    }

    // ── getTopGames ───────────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_top_games_endpoint(): void
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

        $service->getTopGames();

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/games/top', $capturedParams['endpoint']);
    }

    #[Test]
    public function it_returns_a_data_collection_of_games(): void
    {
        $gameData = $this->gameData();

        $service = new class($gameData, 'client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $gameData
             */
            public function __construct(
                private readonly array $gameData,
                string $clientId,
                string $clientSecret,
            ) {
                parent::__construct($clientId, $clientSecret);
            }

            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                return ['data' => [$this->gameData]];
            }
        };

        $dataCollection = $service->getGames(ids: ['game-1']);

        $this->assertInstanceOf(DataCollection::class, $dataCollection);
        $this->assertInstanceOf(Game::class, $dataCollection->first());
        $this->assertSame('game-1', $dataCollection->first()->id);
        $this->assertSame('Fortnite', $dataCollection->first()->name);
    }

    #[Test]
    public function it_returns_a_paginated_result_of_top_games(): void
    {
        $gameData = $this->gameData();

        $service = new class($gameData, 'client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $gameData
             */
            public function __construct(
                private readonly array $gameData,
                string $clientId,
                string $clientSecret,
            ) {
                parent::__construct($clientId, $clientSecret);
            }

            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                return [
                    'data'       => [$this->gameData],
                    'pagination' => ['cursor' => 'abc123'],
                ];
            }
        };

        $paginatedResult = $service->getTopGames();

        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $this->assertCount(1, $paginatedResult->items);
        $this->assertInstanceOf(Game::class, $paginatedResult->items[0]);
        $this->assertSame('Fortnite', $paginatedResult->items[0]->name);
    }

    /**
     * @return array<string, mixed>
     */
    private function gameData(): array
    {
        return [
            'id'          => 'game-1',
            'name'        => 'Fortnite',
            'box_art_url' => 'https://example.com/boxart.jpg',
            'igdb_id'     => '',
        ];
    }
}
