<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;
use Zairakai\LaravelTwitch\Dto\Polls\Poll;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasPollMethodsTest extends TestCase
{
    // ── getPolls ──────────────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_polls_endpoint(): void
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

        $service->getPolls('1');

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/polls', $capturedParams['endpoint']);
    }

    #[Test]
    public function it_returns_a_paginated_result_of_polls(): void
    {
        $pollData = $this->pollData();

        $service = new class($pollData, 'client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $pollData
             */
            public function __construct(
                private readonly array $pollData,
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
                    'data'       => [$this->pollData],
                    'pagination' => ['cursor' => 'abc123'],
                ];
            }
        };

        $paginatedResult = $service->getPolls('1');

        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $this->assertCount(1, $paginatedResult->items);
        $this->assertInstanceOf(Poll::class, $paginatedResult->items[0]);
        $this->assertSame('poll-1', $paginatedResult->items[0]->id);
        $this->assertSame('Best game?', $paginatedResult->items[0]->title);
    }

    /**
     * @return array<string, mixed>
     */
    private function pollData(): array
    {
        return [
            'id'                            => 'poll-1',
            'broadcaster_id'                => '1',
            'broadcaster_login'             => 'test',
            'broadcaster_name'              => 'Test',
            'title'                         => 'Best game?',
            'choices'                       => [],
            'channel_points_voting_enabled' => false,
            'channel_points_per_vote'       => 0,
            'status'                        => 'ACTIVE',
            'duration'                      => 300,
            'started_at'                    => '2024-01-01T00:00:00Z',
        ];
    }
}
