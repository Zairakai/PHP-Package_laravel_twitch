<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Charity;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Charity\CharityCampaign;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class CharityCampaignTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $charityCampaign = CharityCampaign::from([
            'id'                  => 'campaign-001',
            'broadcaster_id'      => '12345',
            'broadcaster_login'   => 'twitchdev',
            'broadcaster_name'    => 'TwitchDev',
            'charity_name'        => 'Save the Forests',
            'charity_description' => 'Help plant trees worldwide.',
            'charity_logo'        => 'https://example.com/logo.png',
            'charity_website'     => 'https://example.com',
            'current_amount'      => ['value' => 5000, 'decimal_places' => 2, 'currency' => 'USD'],
            'target_amount'       => ['value' => 100000, 'decimal_places' => 2, 'currency' => 'USD'],
        ]);

        $this->assertSame('campaign-001', $charityCampaign->id);
        $this->assertSame('Save the Forests', $charityCampaign->charityName);
        $this->assertSame('USD', $charityCampaign->currentAmount['currency']);
        $this->assertSame(100000, $charityCampaign->targetAmount['value']);
    }

    #[Test]
    public function it_handles_null_target_amount(): void
    {
        $charityCampaign = CharityCampaign::from([
            'id'                  => 'campaign-002',
            'broadcaster_id'      => '12345',
            'broadcaster_login'   => 'twitchdev',
            'broadcaster_name'    => 'TwitchDev',
            'charity_name'        => 'Help Fund',
            'charity_description' => '',
            'charity_logo'        => '',
            'charity_website'     => '',
            'current_amount'      => ['value' => 0, 'decimal_places' => 2, 'currency' => 'USD'],
        ]);

        $this->assertNull($charityCampaign->targetAmount);
    }
}
