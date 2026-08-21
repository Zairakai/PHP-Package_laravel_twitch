<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\EventSub\Events;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChatNotificationEvent;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class ChannelChatNotificationEventTest extends TestCase
{
    #[Test]
    public function it_accepts_a_null_color_field(): void
    {
        // Same real-world field as ChannelChatMessageEvent::$color - null for
        // any chatter without a set name color, not the empty string shown in
        // Twitch's docs example.
        $event = ChannelChatNotificationEvent::from(self::minimalPayload(null));

        $this->assertNull($event->color);
    }

    #[Test]
    public function it_accepts_a_populated_color_field(): void
    {
        $event = ChannelChatNotificationEvent::from(self::minimalPayload('#00FF7F'));

        $this->assertSame('#00FF7F', $event->color);
    }

    /**
     * @return array<string, mixed>
     */
    private static function minimalPayload(?string $color): array
    {
        return [
            'broadcaster_user_id'    => '1971641',
            'broadcaster_user_login' => 'streamer',
            'broadcaster_user_name'  => 'streamer',
            'chatter_user_id'        => '49912639',
            'chatter_user_login'     => 'viewer23',
            'chatter_user_name'      => 'viewer23',
            'chatter_is_anonymous'   => false,
            'color'                  => $color,
            'badges'                 => [],
            'system_message'         => 'viewer23 subscribed at Tier 1.',
            'message_id'             => 'd62235c8-47ff-a4f4-84e8-5a29a65a9c03',
            'message'                => [
                'text'      => '',
                'fragments' => [],
            ],
            'notice_type'            => 'resub',
            'resub'                  => [
                'cumulative_months'   => 10,
                'duration_months'     => 0,
                'streak_months'       => null,
                'sub_plan'            => '1000',
                'is_gift'             => false,
                'gifter_is_anonymous' => null,
                'gifter_user_id'      => null,
                'gifter_user_name'    => null,
                'gifter_user_login'   => null,
            ],
        ];
    }
}
