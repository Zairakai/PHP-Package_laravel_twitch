<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Moderation;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Moderation\ModeratedChannel;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class ModeratedChannelTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $moderatedChannel = ModeratedChannel::from([
            'broadcaster_id'    => '12345',
            'broadcaster_login' => 'twitchdev',
            'broadcaster_name'  => 'TwitchDev',
        ]);

        $this->assertSame('12345', $moderatedChannel->broadcasterId);
        $this->assertSame('twitchdev', $moderatedChannel->broadcasterLogin);
        $this->assertSame('TwitchDev', $moderatedChannel->broadcasterName);
    }
}
