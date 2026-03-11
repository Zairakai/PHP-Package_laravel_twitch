<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Spatie\LaravelData\DataCollection;
use Zairakai\LaravelTwitch\Dto\Goals\Goal;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasGoalsMethodsTest extends TestCase
{
    // ── getCreatorGoals ───────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_goals_endpoint(): void
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

        $service->getCreatorGoals('1');

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/goals', $capturedParams['endpoint']);
        $this->assertSame(['broadcaster_id' => '1'], $capturedParams['params']);
    }

    #[Test]
    public function it_returns_a_data_collection_of_goals(): void
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
                            'id'                => 'goal-1',
                            'broadcaster_id'    => '1',
                            'broadcaster_name'  => 'Test',
                            'broadcaster_login' => 'test',
                            'type'              => 'follower',
                            'description'       => 'Get 1000 followers',
                            'current_amount'    => 500,
                            'target_amount'     => 1000,
                            'created_at'        => '2024-01-01T00:00:00Z',
                        ],
                    ],
                ];
            }
        };

        $dataCollection = $service->getCreatorGoals('1');

        $this->assertInstanceOf(DataCollection::class, $dataCollection);
        $this->assertInstanceOf(Goal::class, $dataCollection->first());
        $this->assertSame('goal-1', $dataCollection->first()->id);
        $this->assertSame(500, $dataCollection->first()->currentAmount);
        $this->assertSame(1000, $dataCollection->first()->targetAmount);
    }
}
