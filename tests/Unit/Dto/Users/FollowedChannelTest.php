<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Users;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Users\FollowedChannel;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class FollowedChannelTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $followedChannel = FollowedChannel::from([
            'broadcaster_id'    => '12345',
            'broadcaster_login' => 'twitchdev',
            'broadcaster_name'  => 'TwitchDev',
            'followed_at'       => '2022-06-01T00:00:00Z',
        ]);

        self::assertSame('12345', $followedChannel->broadcasterId);
        self::assertSame('twitchdev', $followedChannel->broadcasterLogin);
        self::assertInstanceOf(Carbon::class, $followedChannel->followedAt);
    }
}
