<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Charity\CharityCampaign;
use Zairakai\LaravelTwitch\Dto\Charity\CharityDonation;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasCharityMethodsTest extends TestCase
{
    // ── getCharityCampaign ────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_charity_campaigns_endpoint(): void
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

                return [
                    'data' => [
                        [
                            'id'                  => 'camp-1',
                            'broadcaster_id'      => '1',
                            'broadcaster_login'   => 'test',
                            'broadcaster_name'    => 'Test',
                            'charity_name'        => 'Charity',
                            'charity_description' => 'Desc',
                            'charity_logo'        => 'https://example.com/logo.png',
                            'charity_website'     => 'https://example.com',
                            'current_amount'      => ['value' => 100, 'decimal_places' => 2, 'currency' => 'USD'],
                            'target_amount'       => ['value' => 1000, 'decimal_places' => 2, 'currency' => 'USD'],
                        ],
                    ],
                ];
            }
        };

        $service->getCharityCampaign('1');

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/charity/campaigns', $capturedParams['endpoint']);
        $this->assertSame(['broadcaster_id' => '1'], $capturedParams['params']);
    }

    // ── getCharityCampaignDonations ───────────────────────────────────────────

    #[Test]
    public function it_calls_the_charity_donations_endpoint(): void
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

        $service->getCharityCampaignDonations('1');

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/charity/donations', $capturedParams['endpoint']);
    }

    #[Test]
    public function it_returns_a_charity_campaign_dto(): void
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
                            'id'                  => 'camp-1',
                            'broadcaster_id'      => '1',
                            'broadcaster_login'   => 'test',
                            'broadcaster_name'    => 'Test',
                            'charity_name'        => 'Charity',
                            'charity_description' => 'Desc',
                            'charity_logo'        => 'https://example.com/logo.png',
                            'charity_website'     => 'https://example.com',
                            'current_amount'      => ['value' => 100, 'decimal_places' => 2, 'currency' => 'USD'],
                            'target_amount'       => ['value' => 1000, 'decimal_places' => 2, 'currency' => 'USD'],
                        ],
                    ],
                ];
            }
        };

        $charityCampaign = $service->getCharityCampaign('1');

        $this->assertInstanceOf(CharityCampaign::class, $charityCampaign);
        $this->assertSame('camp-1', $charityCampaign->id);
        $this->assertSame('Charity', $charityCampaign->charityName);
    }

    #[Test]
    public function it_returns_a_paginated_result_of_charity_donations(): void
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
                            'id'          => 'don-1',
                            'campaign_id' => 'camp-1',
                            'user_id'     => '1',
                            'user_login'  => 'test',
                            'user_name'   => 'Test',
                            'amount'      => ['value' => 100, 'decimal_places' => 2, 'currency' => 'USD'],
                        ],
                    ],
                    'pagination' => ['cursor' => 'abc123'],
                ];
            }
        };

        $paginatedResult = $service->getCharityCampaignDonations('1');

        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $this->assertCount(1, $paginatedResult->items);
        $this->assertInstanceOf(CharityDonation::class, $paginatedResult->items[0]);
        $this->assertSame('don-1', $paginatedResult->items[0]->id);
    }
}
