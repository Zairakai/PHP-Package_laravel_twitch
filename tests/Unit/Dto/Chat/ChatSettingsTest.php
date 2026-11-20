<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Chat;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Chat\ChatSettings;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class ChatSettingsTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $chatSettings = ChatSettings::from([
            'broadcaster_id'                    => '12345',
            'emote_mode'                        => false,
            'follower_mode'                     => true,
            'slow_mode'                         => false,
            'subscriber_mode'                   => false,
            'unique_chat_mode'                  => false,
            'follower_mode_duration'            => 10,
            'slow_mode_wait_time'               => null,
            'non_moderator_chat_delay'          => false,
            'non_moderator_chat_delay_duration' => null,
        ]);

        self::assertSame('12345', $chatSettings->broadcasterId);
        self::assertFalse($chatSettings->emoteMode);
        self::assertTrue($chatSettings->followerMode);
        self::assertSame(10, $chatSettings->followerModeDuration);
        self::assertNull($chatSettings->slowModeWaitTime);
    }
}
