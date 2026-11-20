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

        self::assertSame('98765', $charityDonation->id);
        self::assertSame('charity-123', $charityDonation->campaignId);
        self::assertSame('12345', $charityDonation->userId);
        self::assertSame('donor_user', $charityDonation->userLogin);
        self::assertSame('DonorUser', $charityDonation->userName);
        self::assertIsArray($charityDonation->amount);
        self::assertSame(1000, $charityDonation->amount['value']);
        self::assertSame('USD', $charityDonation->amount['currency']);
    }
}
