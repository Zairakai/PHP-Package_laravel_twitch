<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Users;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Users\Subscription;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class SubscriptionTest extends TestCase
{
    #[Test]
    public function it_can_be_created_for_gifted_subscription(): void
    {
        $subscription = Subscription::from([
            'broadcaster_id'    => '12345',
            'broadcaster_login' => 'twitchdev',
            'broadcaster_name'  => 'TwitchDev',
            'plan_name'         => 'Channel Subscription (twitchdev)',
            'tier'              => '2000',
            'user_id'           => '88888',
            'user_login'        => 'giftrecipient',
            'user_name'         => 'GiftRecipient',
            'is_gift'           => true,
            'gifter_login'      => 'generousgifter',
            'gifter_name'       => 'GenerousGifter',
        ]);

        $this->assertTrue($subscription->isGift);
        $this->assertSame('generousgifter', $subscription->gifterLogin);
        $this->assertSame('2000', $subscription->tier);
    }

    #[Test]
    public function it_can_be_created_for_self_subscription(): void
    {
        $subscription = Subscription::from([
            'broadcaster_id'    => '12345',
            'broadcaster_login' => 'twitchdev',
            'broadcaster_name'  => 'TwitchDev',
            'plan_name'         => 'Channel Subscription (twitchdev)',
            'tier'              => '1000',
            'user_id'           => '99999',
            'user_login'        => 'viewer',
            'user_name'         => 'Viewer',
            'is_gift'           => false,
        ]);

        $this->assertSame('12345', $subscription->broadcasterId);
        $this->assertSame('1000', $subscription->tier);
        $this->assertFalse($subscription->isGift);
        $this->assertNull($subscription->gifterLogin);
        $this->assertNull($subscription->message);
    }
}
