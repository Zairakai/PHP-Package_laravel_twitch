<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Charity;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Charity\CharityDonation;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class CharityDonationTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $charityDonation = CharityDonation::from([
            'id'          => '98765',
            'campaign_id' => 'charity-123',
            'user_id'     => '12345',
            'user_login'  => 'donor_user',
            'user_name'   => 'DonorUser',
            'amount'      => [
                'value'          => 1000,
                'decimal_places' => 2,
                'currency'       => 'USD',
            ],
        ]);

        $this->assertSame('98765', $charityDonation->id);
        $this->assertSame('charity-123', $charityDonation->campaignId);
        $this->assertSame('12345', $charityDonation->userId);
        $this->assertSame('donor_user', $charityDonation->userLogin);
        $this->assertSame('DonorUser', $charityDonation->userName);
        $this->assertIsArray($charityDonation->amount);
        $this->assertSame(1000, $charityDonation->amount['value']);
        $this->assertSame('USD', $charityDonation->amount['currency']);
    }
}
