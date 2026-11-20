<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasAdsMethodsTest extends TestCase
{
    // ── getAdSchedule ─────────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_ads_schedule_endpoint(): void
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
                            'duration'          => 30,
                            'snooze_count'      => 0,
                            'preroll_free_time' => 0,
                        ],
                    ],
                ];
            }
        };

        $service->getAdSchedule('123');

        self::assertIsArray($capturedParams);
        self::assertSame('GET', $capturedParams['method']);
        self::assertSame('/channels/ads', $capturedParams['endpoint']);
        self::assertSame([
            'broadcaster_id' => '123',
        ], $capturedParams['params']);
    }

    // ── snoozeNextAd ──────────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_snooze_next_ad_endpoint(): void
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
                            'broadcaster_id' => '123',
                            'snooze_count'   => 1,
                        ],
                    ],
                ];
            }
        };

        $service->snoozeNextAd('123');

        self::assertIsArray($capturedParams);
        self::assertSame('POST', $capturedParams['method']);
        self::assertSame('/channels/ads/schedule/snooze', $capturedParams['endpoint']);
    }

    // ── startCommercial ───────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_start_commercial_endpoint(): void
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
                            'length'      => 30,
                            'message'     => '',
                            'retry_after' => 480,
                        ],
                    ],
                ];
            }
        };

        $service->startCommercial('123', 30);

        self::assertIsArray($capturedParams);
        self::assertSame('POST', $capturedParams['method']);
        self::assertSame('/channels/commercial', $capturedParams['endpoint']);
    }

    #[Test]
    public function it_returns_a_commercial_result_dto(): void
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
                            'length'      => 30,
                            'message'     => '',
                            'retry_after' => 480,
                        ],
                    ],
                ];
            }
        };

        $commercialResult = $service->startCommercial('123', 30);

        self::assertSame(30, $commercialResult->length);
        self::assertSame(480, $commercialResult->retryAfter);
    }

    #[Test]
    public function it_returns_an_ad_schedule_dto(): void
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
                            'duration'          => 30,
                            'snooze_count'      => 0,
                            'preroll_free_time' => 0,
                        ],
                    ],
                ];
            }
        };

        $adSchedule = $service->getAdSchedule('123');

        self::assertSame(30, $adSchedule->duration);
        self::assertSame(0, $adSchedule->snoozeCount);
    }

    #[Test]
    public function it_returns_an_ad_snooze_dto(): void
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
                            'broadcaster_id' => '123',
                            'snooze_count'   => 1,
                        ],
                    ],
                ];
            }
        };

        $adSnooze = $service->snoozeNextAd('123');

        self::assertSame('123', $adSnooze->broadcasterId);
        self::assertSame(1, $adSnooze->snoozeCount);
    }
}
