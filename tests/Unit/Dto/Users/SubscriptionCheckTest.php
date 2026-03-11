<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Users;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Users\SubscriptionCheck;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class SubscriptionCheckTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $subscriptionCheck = SubscriptionCheck::from([
            'broadcaster_id'    => '12345',
            'broadcaster_login' => 'twitchdev',
            'broadcaster_name'  => 'TwitchDev',
            'tier'              => '3000',
            'is_gift'           => false,
        ]);

        $this->assertSame('3000', $subscriptionCheck->tier);
        $this->assertFalse($subscriptionCheck->isGift);
        $this->assertNull($subscriptionCheck->gifterLogin);
        $this->assertNull($subscriptionCheck->gifterName);
    }
}
