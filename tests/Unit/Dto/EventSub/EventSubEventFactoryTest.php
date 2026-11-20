<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\EventSub;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChatMessageEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChatNotificationEvent;
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
    public function it_casts_follow_timestamps_with_fractional_seconds_to_carbon(): void
    {
        // Real Twitch payloads use variable-precision fractional seconds
        // (microsecond here) that spatie/laravel-data's default DateTimeInterfaceCast
        // rejects outright - FlexibleDateTimeCast must handle it.
        $eventSubEvent = EventSubEventFactory::make('channel.follow', [
            'user_id'                => '111',
            'user_login'             => 'follower',
            'user_name'              => 'Follower',
            'broadcaster_user_id'    => '12345',
            'broadcaster_user_login' => 'zairakai',
            'broadcaster_user_name'  => 'Zairakai',
            'followed_at'            => '2020-07-15T17:16:03.171067Z',
        ]);

        self::assertInstanceOf(ChannelFollowEvent::class, $eventSubEvent);
        self::assertSame('2020-07-15T17:16:03+00:00', $eventSubEvent->followedAt->toIso8601String());
    }

    #[Test]
    public function it_falls_back_to_generic_event_for_unmapped_type(): void
    {
        // Type intentionally does not exist in Twitch's catalog - every real
        // EventSub type is mapped to a dedicated DTO (see
        // EventSubEventFactoryRealPayloadsTest for full coverage proof).
        $eventSubEvent = EventSubEventFactory::make('channel.a_type_twitch_has_not_invented_yet', [
            'id' => 'poll-1',
        ]);

        self::assertInstanceOf(GenericEventSubEvent::class, $eventSubEvent);
        self::assertSame('channel.a_type_twitch_has_not_invented_yet', $eventSubEvent->type);
        self::assertSame([
            'id' => 'poll-1',
        ], $eventSubEvent->payload);
    }

    #[Test]
    public function it_reads_a_gifted_drops_summary_chat_notification(): void
    {
        // notice_type gifted_drops_summary (and its shared-chat mirror) was added by Twitch on 2026-10-01.
        $eventSubEvent = EventSubEventFactory::make('channel.chat.notification', [
            'broadcaster_user_id'    => '1',
            'broadcaster_user_login' => 'someone',
            'broadcaster_user_name'  => 'Someone',
            'chatter_user_id'        => '2',
            'chatter_user_login'     => 'viewer',
            'chatter_user_name'      => 'Viewer',
            'chatter_is_anonymous'   => false,
            'color'                  => '#FF0000',
            'badges'                 => [],
            'system_message'         => '5 viewers received a drop',
            'message_id'             => 'msg-1',
            'message'                => [
                'text'      => '',
                'fragments' => [],
            ],
            'notice_type'            => 'gifted_drops_summary',
            'gifted_drops_summary'   => [
                'recipient_count' => 5,
            ],
        ]);

        self::assertInstanceOf(ChannelChatNotificationEvent::class, $eventSubEvent);
        self::assertSame([
            'recipient_count' => 5,
        ], $eventSubEvent->giftedDropsSummary);
        self::assertNull($eventSubEvent->sharedChatGiftedDropsSummary);
    }

    #[Test]
    public function it_reads_the_id_of_a_stream_offline_notification(): void
    {
        // Twitch added `id` to stream.offline on 2026-06-26; older payloads do not have it.
        $withId = EventSubEventFactory::make('stream.offline', [
            'id'                     => '40000000001',
            'broadcaster_user_id'    => '1',
            'broadcaster_user_login' => 'someone',
            'broadcaster_user_name'  => 'Someone',
        ]);
        $withoutId = EventSubEventFactory::make('stream.offline', [
            'broadcaster_user_id'    => '1',
            'broadcaster_user_login' => 'someone',
            'broadcaster_user_name'  => 'Someone',
        ]);

        self::assertInstanceOf(StreamOfflineEvent::class, $withId);
        self::assertSame('40000000001', $withId->id);
        self::assertInstanceOf(StreamOfflineEvent::class, $withoutId);
        self::assertNull($withoutId->id);
    }

    #[Test]
    public function it_resolves_broadcaster_user_id_from_the_generic_event_payload_when_present(): void
    {
        $eventSubEvent = EventSubEventFactory::make('channel.a_type_twitch_has_not_invented_yet', [
            'broadcaster_user_id' => '12345',
        ]);

        self::assertSame('12345', $eventSubEvent->getBroadcasterUserId());
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
            'color'        => '#00FF7F',
            'badges'       => [],
            'message_type' => 'text',
        ]);

        self::assertInstanceOf(ChannelChatMessageEvent::class, $eventSubEvent);
        self::assertSame('!ping', $eventSubEvent->message->text);
        self::assertSame('viewer', $eventSubEvent->chatterUserLogin);
        self::assertNull($eventSubEvent->sourceBroadcasterUserId);
    }

    #[Test]
    public function it_resolves_channel_chat_message_event_from_a_shared_chat_session(): void
    {
        $eventSubEvent = EventSubEventFactory::make('channel.chat.message', [
            'broadcaster_user_id'             => '1971641',
            'broadcaster_user_login'          => 'streamer',
            'broadcaster_user_name'           => 'streamer',
            'chatter_user_id'                 => '4145994',
            'chatter_user_login'              => 'viewer32',
            'chatter_user_name'               => 'viewer32',
            'message_id'                      => 'cc106a89-1814-919d-454c-f4f2f970aae7',
            'message'                         => [
                'text'      => 'Hi chat',
                'fragments' => [],
            ],
            'color'                           => '#00FF7F',
            'badges'                          => [],
            'message_type'                    => 'text',
            'source_broadcaster_user_id'      => '112233',
            'source_broadcaster_user_login'   => 'streamer33',
            'source_broadcaster_user_name'    => 'streamer33',
            'source_message_id'               => 'e03f6d5d-8ec8-4c63-b473-9e5fe61e289b',
            'source_badges'                   => [
                [
                    'set_id' => 'subscriber',
                    'id'     => '3',
                    'info'   => '3',
                ],
            ],
            'is_source_only'                  => true,
        ]);

        self::assertInstanceOf(ChannelChatMessageEvent::class, $eventSubEvent);
        self::assertSame('112233', $eventSubEvent->sourceBroadcasterUserId);
        self::assertTrue($eventSubEvent->isSourceOnly);
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

        self::assertInstanceOf(ChannelFollowEvent::class, $eventSubEvent);
        self::assertSame('follower', $eventSubEvent->userLogin);
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

        self::assertInstanceOf(ChannelSubscribeEvent::class, $eventSubEvent);
        self::assertSame('1000', $eventSubEvent->tier);
        self::assertFalse($eventSubEvent->isGift);
    }

    #[Test]
    public function it_resolves_stream_offline_event(): void
    {
        $eventSubEvent = EventSubEventFactory::make('stream.offline', [
            'broadcaster_user_id'    => '12345',
            'broadcaster_user_login' => 'zairakai',
            'broadcaster_user_name'  => 'Zairakai',
        ]);

        self::assertInstanceOf(StreamOfflineEvent::class, $eventSubEvent);
        self::assertSame('12345', $eventSubEvent->broadcasterUserId);
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

        self::assertInstanceOf(StreamOnlineEvent::class, $eventSubEvent);
        self::assertSame('live', $eventSubEvent->type);
    }

    #[Test]
    public function it_returns_null_broadcaster_user_id_from_the_generic_event_payload_when_absent(): void
    {
        $eventSubEvent = EventSubEventFactory::make('channel.a_type_twitch_has_not_invented_yet', [
            'id' => 'poll-1',
        ]);

        self::assertNull($eventSubEvent->getBroadcasterUserId());
    }
}
