<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Spatie\LaravelData\DataCollection;
use Zairakai\LaravelTwitch\Dto\ChannelPoints\CustomReward;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasChannelPointsMethodsTest extends TestCase
{
    // ── getCustomRewards ──────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_custom_rewards_endpoint(): void
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

        $service->getCustomRewards('1');

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/channel_points/custom_rewards', $capturedParams['endpoint']);
    }

    #[Test]
    public function it_returns_a_data_collection_of_custom_rewards(): void
    {
        $rewardData = $this->customRewardData();

        $service = new class($rewardData, 'client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $rewardData
             */
            public function __construct(
                private readonly array $rewardData,
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
                return ['data' => [$this->rewardData]];
            }
        };

        $dataCollection = $service->getCustomRewards('1');

        $this->assertInstanceOf(DataCollection::class, $dataCollection);
        $this->assertInstanceOf(CustomReward::class, $dataCollection->first());
        $this->assertSame('reward-1', $dataCollection->first()->id);
        $this->assertSame('Hydrate!', $dataCollection->first()->title);
    }

    /**
     * @return array<string, mixed>
     */
    private function customRewardData(): array
    {
        return [
            'broadcaster_id'                        => '1',
            'broadcaster_login'                     => 'test',
            'broadcaster_name'                      => 'Test',
            'id'                                    => 'reward-1',
            'title'                                 => 'Hydrate!',
            'prompt'                                => 'Remind me to drink water',
            'cost'                                  => 500,
            'background_color'                      => '#00AABB',
            'is_enabled'                            => true,
            'is_user_input_required'                => false,
            'is_paused'                             => false,
            'is_in_stock'                           => true,
            'should_redemptions_skip_request_queue' => false,
        ];
    }
}
