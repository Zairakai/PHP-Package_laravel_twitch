<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;
use Zairakai\LaravelTwitch\Dto\Predictions\Prediction;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasPredictionMethodsTest extends TestCase
{
    // ── getPredictions ────────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_predictions_endpoint(): void
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

        $service->getPredictions('1');

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/predictions', $capturedParams['endpoint']);
    }

    #[Test]
    public function it_returns_a_paginated_result_of_predictions(): void
    {
        $predictionData = $this->predictionData();

        $service = new class($predictionData, 'client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $predictionData
             */
            public function __construct(
                private readonly array $predictionData,
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
                    'data'       => [$this->predictionData],
                    'pagination' => ['cursor' => 'abc123'],
                ];
            }
        };

        $paginatedResult = $service->getPredictions('1');

        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $this->assertCount(1, $paginatedResult->items);
        $this->assertInstanceOf(Prediction::class, $paginatedResult->items[0]);
        $this->assertSame('pred-1', $paginatedResult->items[0]->id);
        $this->assertSame('Will I win?', $paginatedResult->items[0]->title);
    }

    /**
     * @return array<string, mixed>
     */
    private function predictionData(): array
    {
        return [
            'id'                 => 'pred-1',
            'broadcaster_id'     => '1',
            'broadcaster_login'  => 'test',
            'broadcaster_name'   => 'Test',
            'title'              => 'Will I win?',
            'winning_outcome_id' => null,
            'outcomes'           => [],
            'prediction_window'  => 120,
            'status'             => 'ACTIVE',
            'created_at'         => '2024-01-01T00:00:00Z',
            'ended_at'           => null,
            'locked_at'          => null,
        ];
    }
}
