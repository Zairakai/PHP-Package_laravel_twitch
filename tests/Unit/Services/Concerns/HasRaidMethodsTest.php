<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasRaidMethodsTest extends TestCase
{
    // ── getHypeTrainStatus ────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_hypetrain_status_endpoint(): void
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
            protected function makeRequest(
                string $method,
                string $endpoint,
                array $params = [],
            ): array {
                $this->captured = [
                    'method'   => $method,
                    'endpoint' => $endpoint,
                    'params'   => $params,
                ];

                return [
                    'data' => [
                        [
                            'current'              => null,
                            'all_time_high'        => null,
                            'shared_all_time_high' => null,
                        ],
                    ],
                ];
            }
        };

        $service->getHypeTrainStatus('1');

        self::assertIsArray($capturedParams);
        self::assertSame('GET', $capturedParams['method']);
        self::assertSame('/hypetrain/status', $capturedParams['endpoint']);
        self::assertSame([
            'broadcaster_id' => '1',
        ], $capturedParams['params']);
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
            protected function makeRequest(
                string $method,
                string $endpoint,
                array $params = [],
            ): array {
                $this->captured = [
                    'method'   => $method,
                    'endpoint' => $endpoint,
                    'params'   => $params,
                ];

                return [];
            }
        };

        $service->cancelRaid('1');

        self::assertIsArray($capturedParams);
        self::assertSame('DELETE', $capturedParams['method']);
        self::assertSame('/raids', $capturedParams['endpoint']);
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
            protected function makeRequest(
                string $method,
                string $endpoint,
                array $params = [],
            ): array {
                $this->captured = [
                    'method'   => $method,
                    'endpoint' => $endpoint,
                    'params'   => $params,
                ];

                return [
                    'data' => [
                        [
                            'created_at' => '2024-01-01T00:00:00Z',
                            'is_mature'  => false,
                        ],
                    ],
                ];
            }
        };

        $service->startRaid('1', '2');

        self::assertIsArray($capturedParams);
        self::assertSame('POST', $capturedParams['method']);
        self::assertSame('/raids', $capturedParams['endpoint']);
    }

    // ── sendWhisper ───────────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_whispers_endpoint_with_query_and_body_params(): void
    {
        $captured = null;

        $service = new class('client-id', 'secret', $captured) extends TwitchApiService
        {
            public function __construct(
                string $clientId,
                string $clientSecret,
                public mixed &$captured,
            ) {
                parent::__construct($clientId, $clientSecret);
            }

            /**
             * @param array<string, mixed> $queryParams
             * @param array<string, mixed> $bodyParams
             */
            protected function makeQueryAndBodyRequest(
                string $method,
                string $endpoint,
                array $queryParams,
                array $bodyParams = [],
            ): array {
                $this->captured = [
                    'method'      => $method,
                    'endpoint'    => $endpoint,
                    'queryParams' => $queryParams,
                    'bodyParams'  => $bodyParams,
                ];

                return [];
            }
        };

        $service->sendWhisper(
            '123',
            '456',
            'hello',
        );

        self::assertIsArray($captured);
        self::assertSame('POST', $captured['method']);
        self::assertSame('/whispers', $captured['endpoint']);
        self::assertSame([
            'from_user_id' => '123',
            'to_user_id'   => '456',
        ], $captured['queryParams']);
        self::assertSame([
            'message' => 'hello',
        ], $captured['bodyParams']);
    }

    #[Test]
    public function it_returns_a_hype_train_status_dto(): void
    {
        $service = new class('client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(
                string $method,
                string $endpoint,
                array $params = [],
            ): array {
                return [
                    'data' => [
                        [
                            'current' => [
                                'id'                     => 'ht-1',
                                'broadcaster_user_id'    => '1',
                                'broadcaster_user_login' => 'cool_user',
                                'broadcaster_user_name'  => 'Cool_User',
                                'level'                  => 2,
                                'total'                  => 700,
                                'progress'               => 200,
                                'goal'                   => 1000,
                                'top_contributions'      => [
                                    [
                                        'user_id'    => '123',
                                        'user_login' => 'pogchamp',
                                        'user_name'  => 'PogChamp',
                                        'type'       => 'bits',
                                        'total'      => 50,
                                    ],
                                ],
                                'shared_train_participants' => null,
                                'started_at'                => '2024-01-01T00:00:00Z',
                                'expires_at'                => '2024-01-01T01:00:00Z',
                                'type'                      => 'regular',
                                'is_shared_train'           => false,
                            ],
                            'all_time_high' => [
                                'level'       => 6,
                                'total'       => 2850,
                                'achieved_at' => '2024-01-01T00:00:00Z',
                            ],
                            'shared_all_time_high' => null,
                        ],
                    ],
                ];
            }
        };

        $hypeTrainStatus = $service->getHypeTrainStatus('1');

        self::assertNotNull($hypeTrainStatus->current);
        self::assertSame('ht-1', $hypeTrainStatus->current->id);
        self::assertSame(2, $hypeTrainStatus->current->level);
        self::assertCount(1, $hypeTrainStatus->current->topContributions);
        self::assertNull($hypeTrainStatus->current->sharedTrainParticipants);
        self::assertNotNull($hypeTrainStatus->allTimeHigh);
        self::assertSame(6, $hypeTrainStatus->allTimeHigh->level);
        self::assertNull($hypeTrainStatus->sharedAllTimeHigh);
    }

    #[Test]
    public function it_returns_a_raid_dto(): void
    {
        $service = new class('client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(
                string $method,
                string $endpoint,
                array $params = [],
            ): array {
                return [
                    'data' => [
                        [
                            'created_at' => '2024-01-01T00:00:00Z',
                            'is_mature'  => false,
                        ],
                    ],
                ];
            }
        };

        $raid = $service->startRaid('1', '2');

        self::assertFalse($raid->isMature);
    }
}
