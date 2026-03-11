<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\EventSub\Subscription;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasEventSubMethodsTest extends TestCase
{
    // ── getEventSubSubscriptions ──────────────────────────────────────────────

    #[Test]
    public function it_calls_the_eventsub_subscriptions_endpoint(): void
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

        $service->getEventSubSubscriptions();

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/eventsub/subscriptions', $capturedParams['endpoint']);
    }

    // ── createEventSubSubscription ────────────────────────────────────────────

    #[Test]
    public function it_calls_the_eventsub_subscriptions_endpoint_on_create(): void
    {
        $capturedParams   = null;
        $subscriptionData = $this->subscriptionData();

        $service = new class($subscriptionData, 'client-id', 'secret', $capturedParams) extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $subscriptionData
             */
            public function __construct(
                private readonly array $subscriptionData,
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

                return ['data' => [$this->subscriptionData]];
            }
        };

        $subscription = $service->createEventSubSubscription(
            'channel.follow',
            ['broadcaster_user_id' => '1'],
            'https://example.com/webhook',
            'my-secret',
        );

        $this->assertSame('POST', $capturedParams['method']);
        $this->assertSame('/eventsub/subscriptions', $capturedParams['endpoint']);
        $this->assertInstanceOf(Subscription::class, $subscription);
    }

    #[Test]
    public function it_returns_a_paginated_result_of_eventsub_subscriptions(): void
    {
        $subscriptionData = $this->subscriptionData();

        $service = new class($subscriptionData, 'client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $subscriptionData
             */
            public function __construct(
                private readonly array $subscriptionData,
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
                    'data'       => [$this->subscriptionData],
                    'pagination' => ['cursor' => 'abc123'],
                ];
            }
        };

        $paginatedResult = $service->getEventSubSubscriptions();

        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $this->assertCount(1, $paginatedResult->items);
        $this->assertInstanceOf(Subscription::class, $paginatedResult->items[0]);
        $this->assertSame('sub-1', $paginatedResult->items[0]->id);
        $this->assertSame('enabled', $paginatedResult->items[0]->status);
    }

    /**
     * @return array<string, mixed>
     */
    private function subscriptionData(): array
    {
        return [
            'id'         => 'sub-1',
            'status'     => 'enabled',
            'type'       => 'channel.follow',
            'version'    => '1',
            'condition'  => ['broadcaster_user_id' => '1'],
            'created_at' => '2024-01-01T00:00:00Z',
            'transport'  => ['method' => 'webhook', 'callback' => 'https://example.com/webhook'],
            'cost'       => 1,
        ];
    }
}
