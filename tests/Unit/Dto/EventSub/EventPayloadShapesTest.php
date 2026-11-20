<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\EventSub;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\AutomodSettingsUpdateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelAdBreakBeginEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelBanEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChatNotificationEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChatSettingsUpdateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelGuestStarGuestUpdateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelGuestStarSessionBeginEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelGuestStarSessionEndEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelHypeTrainBeginEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelModerateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelUnbanRequestResolveEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelWarningSendEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\UserAuthorizationRevokeEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\EventSubEventFactory;
use Zairakai\LaravelTwitch\Tests\TestCase;

/**
 * Payloads as the EventSub reference describes them, with the fields that can be null or absent.
 */
final class EventPayloadShapesTest extends TestCase
{
    private const array BROADCASTER = [
        'broadcaster_user_id'    => '1',
        'broadcaster_user_login' => 'b',
        'broadcaster_user_name'  => 'B',
    ];

    private const array MODERATOR = [
        'moderator_user_id'    => '9',
        'moderator_user_login' => 'mod',
        'moderator_user_name'  => 'Mod',
    ];

    private const array USER = [
        'user_id'    => '2',
        'user_login' => 'u',
        'user_name'  => 'U',
    ];

    #[Test]
    public function it_reads_a_permanent_ban_that_has_no_end(): void
    {
        // The most common ban: `ends_at` is null. The DTO used to refuse it and the event was dropped.
        $permanent = EventSubEventFactory::make('channel.ban', self::USER + self::BROADCASTER + self::MODERATOR + [
            'reason'       => 'spam',
            'banned_at'    => '2026-11-20T10:00:00.123456789Z',
            'ends_at'      => null,
            'is_permanent' => true,
        ]);
        $timeout = EventSubEventFactory::make('channel.ban', self::USER + self::BROADCASTER + self::MODERATOR + [
            'reason'       => 'spam',
            'banned_at'    => '2026-11-20T10:00:00Z',
            'ends_at'      => '2026-11-20T10:10:00Z',
            'is_permanent' => false,
        ]);

        self::assertInstanceOf(ChannelBanEvent::class, $permanent);
        self::assertNull($permanent->endsAt);
        self::assertTrue($permanent->isPermanent);
        self::assertInstanceOf(ChannelBanEvent::class, $timeout);
        self::assertNotNull($timeout->endsAt);
    }

    #[Test]
    public function it_reads_a_revocation_for_a_user_that_no_longer_exists(): void
    {
        $event = EventSubEventFactory::make('user.authorization.revoke', [
            'client_id'  => 'cid',
            'user_id'    => '2',
            'user_login' => null,
            'user_name'  => null,
        ]);

        self::assertInstanceOf(UserAuthorizationRevokeEvent::class, $event);
        self::assertNull($event->userLogin);
    }

    #[Test]
    public function it_reads_a_warning_without_a_reason(): void
    {
        $event = EventSubEventFactory::make('channel.warning.send', self::BROADCASTER + self::MODERATOR + self::USER + [
            'reason'           => null,
            'chat_rules_cited' => null,
        ]);

        self::assertInstanceOf(ChannelWarningSendEvent::class, $event);
        self::assertNull($event->reason);
    }

    #[Test]
    public function it_reads_an_unban_request_resolved_without_a_moderator(): void
    {
        $event = EventSubEventFactory::make('channel.unban_request.resolve', self::BROADCASTER + self::USER + [
            'id'                   => 'req-1',
            'moderator_user_id'    => null,
            'moderator_user_login' => null,
            'moderator_user_name'  => null,
            'resolution_text'      => null,
            'status'               => 'canceled',
        ]);

        self::assertInstanceOf(ChannelUnbanRequestResolveEvent::class, $event);
        self::assertNull($event->moderatorUserId);
        self::assertSame('canceled', $event->status);
    }

    #[Test]
    public function it_reads_chat_settings_with_slow_mode_off(): void
    {
        $event = EventSubEventFactory::make('channel.chat_settings.update', self::BROADCASTER + [
            'emote_mode'                     => false,
            'follower_mode'                  => false,
            'follower_mode_duration_minutes' => null,
            'slow_mode'                      => false,
            'slow_mode_wait_time_seconds'    => null,
            'subscriber_mode'                => false,
            'unique_chat_mode'               => false,
        ]);

        self::assertInstanceOf(ChannelChatSettingsUpdateEvent::class, $event);
        self::assertNull($event->slowModeWaitTimeSeconds);
    }

    #[Test]
    public function it_reads_the_automod_settings_whether_they_are_flat_or_wrapped_in_data(): void
    {
        $settings = [
            'broadcaster_user_id'    => '1',
            'broadcaster_user_login' => 'b',
            'broadcaster_user_name'  => 'B',
        ] + self::MODERATOR + [
            'overall_level'              => null,
            'disability'                 => 3,
            'aggression'                 => 3,
            'sexuality_sex_or_gender'    => 3,
            'misogyny'                   => 3,
            'bullying'                   => 3,
            'swearing'                   => 0,
            'race_ethnicity_or_religion' => 3,
            'sex_based_terms'            => 30,
        ];

        $flat    = EventSubEventFactory::make('automod.settings.update', $settings);
        $wrapped = EventSubEventFactory::make('automod.settings.update', [
            'data' => [
                $settings,
            ],
        ]);

        self::assertInstanceOf(AutomodSettingsUpdateEvent::class, $flat);
        self::assertSame(3, $flat->bullying);
        self::assertNull($flat->overallLevel);
        self::assertInstanceOf(AutomodSettingsUpdateEvent::class, $wrapped);
        self::assertSame('1', $wrapped->getBroadcasterUserId());
        self::assertSame(30, $wrapped->sexBasedTerms);
    }

    #[Test]
    public function it_reads_the_guest_star_events_as_the_reference_describes_them(): void
    {
        $update = EventSubEventFactory::make('channel.guest_star_guest.update', self::BROADCASTER + [
            'session_id'          => 's1',
            'moderator_user_id'   => null,
            'guest_user_id'       => '3',
            'slot_id'             => null,
            'state'               => 'invited',
            'host_user_id'        => '1',
            'host_video_enabled'  => null,
            'host_audio_enabled'  => 'true',
            'host_volume'         => '80',
        ]);
        $begin = EventSubEventFactory::make('channel.guest_star_session.begin', self::BROADCASTER + [
            'session_id' => 's1',
            'started_at' => '2026-11-20T10:00:00Z',
        ]);
        $end   = EventSubEventFactory::make('channel.guest_star_session.end', self::BROADCASTER + [
            'session_id'      => 's1',
            'started_at'      => '2026-11-20T10:00:00Z',
            'ended_at'        => '2026-11-20T11:00:00Z',
            'host_user_id'    => '1',
            'host_user_name'  => 'B',
            'host_user_login' => 'b',
        ]);

        self::assertInstanceOf(ChannelGuestStarGuestUpdateEvent::class, $update);
        self::assertNull($update->slotId);
        self::assertTrue($update->hostAudioEnabled);
        self::assertSame(80, $update->hostVolume);
        self::assertInstanceOf(ChannelGuestStarSessionBeginEvent::class, $begin);
        self::assertNull($begin->moderatorUserId);
        self::assertInstanceOf(ChannelGuestStarSessionEndEvent::class, $end);
        self::assertSame('1', $end->hostUserId);
    }

    #[Test]
    public function it_reads_the_numbers_and_booleans_that_the_official_example_sends_as_strings(): void
    {
        // The example of channel.ad_break.begin gives "60" and "false": "false" used to be read as true.
        $event = EventSubEventFactory::make('channel.ad_break.begin', [
            'duration_seconds'       => '60',
            'started_at'             => '2019-11-16T10:11:12.634234626Z',
            'is_automatic'           => 'false',
            'broadcaster_user_id'    => '1337',
            'broadcaster_user_login' => 'cool_user',
            'broadcaster_user_name'  => 'Cool_User',
            'requester_user_id'      => '1337',
            'requester_user_login'   => 'cool_user',
            'requester_user_name'    => 'Cool_User',
        ]);

        self::assertInstanceOf(ChannelAdBreakBeginEvent::class, $event);
        self::assertSame(60, $event->durationSeconds);
        self::assertFalse($event->isAutomatic);
    }

    #[Test]
    public function it_reads_the_participants_of_a_shared_hype_train(): void
    {
        // The participants are channels (broadcaster_user_*), not contributors (user_*): the DTO used to ask for the latter.
        $event = EventSubEventFactory::make('channel.hype_train.begin', self::BROADCASTER + [
            'id'                      => 'h1',
            'total'                   => 100,
            'progress'                => 10,
            'goal'                    => 500,
            'top_contributions'       => [
                [
                    'user_id'    => '2',
                    'user_login' => 'u',
                    'user_name'  => 'U',
                    'type'       => 'bits',
                    'total'      => 50,
                ],
            ],
            'level'                     => 1,
            'all_time_high_level'       => 3,
            'all_time_high_total'       => 900,
            'shared_train_participants' => [
                [
                    'broadcaster_user_id'    => '7',
                    'broadcaster_user_login' => 'p',
                    'broadcaster_user_name'  => 'P',
                ],
            ],
            'started_at'              => '2026-11-20T10:00:00Z',
            'expires_at'              => '2026-11-20T10:05:00Z',
            'type'                    => 'regular',
            'is_shared_train'         => true,
        ]);

        self::assertInstanceOf(ChannelHypeTrainBeginEvent::class, $event);
        self::assertNotNull($event->sharedTrainParticipants);
        self::assertCount(1, $event->sharedTrainParticipants);
    }

    #[Test]
    public function it_reads_the_source_channel_of_a_moderation_action_in_a_shared_chat(): void
    {
        $event = EventSubEventFactory::make('channel.moderate', self::BROADCASTER + self::MODERATOR + [
            'source_broadcaster_user_id'    => '5',
            'source_broadcaster_user_login' => 'other',
            'source_broadcaster_user_name'  => 'Other',
            'action'                        => 'shared_chat_ban',
        ]);

        self::assertInstanceOf(ChannelModerateEvent::class, $event);
        self::assertSame('5', $event->sourceBroadcasterUserId);
        self::assertSame('Other', $event->sourceBroadcasterUserName);
    }

    #[Test]
    public function it_reads_the_tier_of_a_resub_under_either_name(): void
    {
        $base = self::BROADCASTER + [
            'chatter_user_id'      => '2',
            'chatter_user_login'   => 'u',
            'chatter_user_name'    => 'U',
            'chatter_is_anonymous' => false,
            'color'                => '',
            'badges'               => [],
            'system_message'       => 'resub',
            'message_id'           => 'm1',
            'message'              => [
                'text'      => '',
                'fragments' => [],
            ],
            'notice_type'          => 'resub',
        ];
        $resub  = [
            'cumulative_months'   => 10,
            'duration_months'     => 1,
            'streak_months'       => null,
            'is_prime'            => false,
            'is_gift'             => false,
            'gifter_is_anonymous' => null,
            'gifter_user_id'      => null,
            'gifter_user_name'    => null,
            'gifter_user_login'   => null,
        ];
        $tier   = EventSubEventFactory::make('channel.chat.notification', $base + [
            'resub' => $resub + [
                'sub_tier' => '1000',
            ],
        ]);
        $plan   = EventSubEventFactory::make('channel.chat.notification', $base + [
            'resub' => $resub + [
                'sub_plan' => '2000',
            ],
        ]);

        self::assertInstanceOf(ChannelChatNotificationEvent::class, $tier);
        self::assertNotNull($tier->resub);
        self::assertSame('1000', $tier->resub->subTier);
        self::assertSame('1000', $tier->resub->subPlan);
        self::assertInstanceOf(ChannelChatNotificationEvent::class, $plan);
        self::assertNotNull($plan->resub);
        self::assertSame('2000', $plan->resub->subTier);
        self::assertFalse($plan->resub->isPrime);
    }
}
