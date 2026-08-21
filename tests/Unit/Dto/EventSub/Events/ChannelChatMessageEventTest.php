<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\EventSub\Events;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChatMessageEvent;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class ChannelChatMessageEventTest extends TestCase
{
    #[Test]
    public function it_accepts_a_null_color_field(): void
    {
        // Real production traffic sends null for chatters who never set a
        // name color (2026-08-21 live stream: ~9% of messages) - Twitch's own
        // docs example shows an empty string instead, which is what the DTO
        // was typed against. Was non-nullable string, crashed on every one
        // of those messages before they could be persisted.
        $channelChatMessageEvent = ChannelChatMessageEvent::from($this->minimalPayload(null));

        $this->assertNull($channelChatMessageEvent->color);
    }

    #[Test]
    public function it_accepts_a_populated_color_field(): void
    {
        $channelChatMessageEvent = ChannelChatMessageEvent::from($this->minimalPayload('#00FF7F'));

        $this->assertSame('#00FF7F', $channelChatMessageEvent->color);
    }

    /**
     * @return array<string, mixed>
     */
    private function minimalPayload(?string $color): array
    {
        return [
            'broadcaster_user_id'    => '1971641',
            'broadcaster_user_login' => 'streamer',
            'broadcaster_user_name'  => 'streamer',
            'chatter_user_id'        => '4145994',
            'chatter_user_login'     => 'viewer32',
            'chatter_user_name'      => 'viewer32',
            'message_id'             => 'cc106a89-1814-919d-454c-f4f2f970aae7',
            'message'                => [
                'text'      => 'Hi chat',
                'fragments' => [],
            ],
            'color'                  => $color,
            'badges'                 => [],
            'message_type'           => 'text',
        ];
    }
}
