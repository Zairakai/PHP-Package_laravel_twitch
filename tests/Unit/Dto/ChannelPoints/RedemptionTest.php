<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\ChannelPoints;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\ChannelPoints\Redemption;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class RedemptionTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $redemption = Redemption::from([
            'broadcaster_id'    => '12345',
            'broadcaster_login' => 'twitchdev',
            'broadcaster_name'  => 'TwitchDev',
            'id'                => 'redemption-xyz',
            'user_id'           => '99999',
            'user_login'        => 'viewer',
            'user_name'         => 'Viewer',
            'status'            => 'UNFULFILLED',
            'reward_id'         => 'reward-abc',
            'reward_title'      => 'Hydrate!',
            'reward_cost'       => 500,
            'reward_prompt'     => 'Remind me to drink water',
            'user_input'        => 'Please!',
            'redeemed_at'       => '2024-03-01T12:00:00Z',
        ]);

        $this->assertSame('redemption-xyz', $redemption->id);
        $this->assertSame('UNFULFILLED', $redemption->status);
        $this->assertSame('viewer', $redemption->userLogin);
        $this->assertSame(500, $redemption->rewardCost);
        $this->assertSame('Please!', $redemption->userInput);
        $this->assertInstanceOf(Carbon::class, $redemption->redeemedAt);
    }

    #[Test]
    public function it_handles_null_optional_fields(): void
    {
        $redemption = Redemption::from([
            'broadcaster_id'    => '12345',
            'broadcaster_login' => 'twitchdev',
            'broadcaster_name'  => 'TwitchDev',
            'id'                => 'redemption-xyz',
            'user_id'           => '99999',
            'user_login'        => 'viewer',
            'user_name'         => 'Viewer',
            'status'            => 'FULFILLED',
            'reward_id'         => 'reward-abc',
            'reward_title'      => 'Hydrate!',
            'reward_cost'       => 500,
            'reward_prompt'     => '',
        ]);

        $this->assertNull($redemption->userInput);
        $this->assertNull($redemption->redeemedAt);
    }
}
