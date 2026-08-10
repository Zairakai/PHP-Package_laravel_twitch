<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\EventSub;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChatMessageEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelFollowEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelSubscribeEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\GenericEventSubEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\StreamOfflineEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\StreamOnlineEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\EventSubEventFactory;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class EventSubEventFactoryTest extends TestCase
{
    #[Test]
    public function it_falls_back_to_generic_event_for_unmapped_type(): void
    {
        $eventSubEvent = EventSubEventFactory::make('channel.poll.begin', ['id' => 'poll-1']);

        $this->assertInstanceOf(GenericEventSubEvent::class, $eventSubEvent);
        $this->assertSame('channel.poll.begin', $eventSubEvent->type);
        $this->assertSame(['id' => 'poll-1'], $eventSubEvent->payload);
    }

    #[Test]
    public function it_resolves_channel_chat_message_event(): void
    {
        $eventSubEvent = EventSubEventFactory::make('channel.chat.message', [
            'broadcaster_user_id'    => '12345',
            'broadcaster_user_login' => 'zairakai',
            'broadcaster_user_name'  => 'Zairakai',
            'chatter_user_id'        => '67890',
            'chatter_user_login'     => 'viewer',
            'chatter_user_name'      => 'Viewer',
            'message_id'             => 'msg-1',
            'message'                => [
                'text'      => '!ping',
                'fragments' => [],
            ],
            'message_type' => 'text',
            'badges'       => [],
        ]);

        $this->assertInstanceOf(ChannelChatMessageEvent::class, $eventSubEvent);
        $this->assertSame('!ping', $eventSubEvent->message->text);
        $this->assertSame('viewer', $eventSubEvent->chatterUserLogin);
    }

    #[Test]
    public function it_resolves_channel_follow_event(): void
    {
        $eventSubEvent = EventSubEventFactory::make('channel.follow', [
            'user_id'                => '111',
            'user_login'             => 'follower',
            'user_name'              => 'Follower',
            'broadcaster_user_id'    => '12345',
            'broadcaster_user_login' => 'zairakai',
            'broadcaster_user_name'  => 'Zairakai',
            'followed_at'            => '2024-01-01T00:00:00Z',
        ]);

        $this->assertInstanceOf(ChannelFollowEvent::class, $eventSubEvent);
        $this->assertSame('follower', $eventSubEvent->userLogin);
    }

    #[Test]
    public function it_resolves_channel_subscribe_event(): void
    {
        $eventSubEvent = EventSubEventFactory::make('channel.subscribe', [
            'user_id'                => '111',
            'user_login'             => 'subscriber',
            'user_name'              => 'Subscriber',
            'broadcaster_user_id'    => '12345',
            'broadcaster_user_login' => 'zairakai',
            'broadcaster_user_name'  => 'Zairakai',
            'tier'                   => '1000',
            'is_gift'                => false,
        ]);

        $this->assertInstanceOf(ChannelSubscribeEvent::class, $eventSubEvent);
        $this->assertSame('1000', $eventSubEvent->tier);
        $this->assertFalse($eventSubEvent->isGift);
    }

    #[Test]
    public function it_resolves_stream_offline_event(): void
    {
        $eventSubEvent = EventSubEventFactory::make('stream.offline', [
            'broadcaster_user_id'    => '12345',
            'broadcaster_user_login' => 'zairakai',
            'broadcaster_user_name'  => 'Zairakai',
        ]);

        $this->assertInstanceOf(StreamOfflineEvent::class, $eventSubEvent);
        $this->assertSame('12345', $eventSubEvent->broadcasterUserId);
    }

    #[Test]
    public function it_resolves_stream_online_event(): void
    {
        $eventSubEvent = EventSubEventFactory::make('stream.online', [
            'id'                     => 'stream-1',
            'broadcaster_user_id'    => '12345',
            'broadcaster_user_login' => 'zairakai',
            'broadcaster_user_name'  => 'Zairakai',
            'type'                   => 'live',
            'started_at'             => '2024-01-01T00:00:00Z',
        ]);

        $this->assertInstanceOf(StreamOnlineEvent::class, $eventSubEvent);
        $this->assertSame('live', $eventSubEvent->type);
    }
}
