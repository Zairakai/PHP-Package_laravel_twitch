<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Ads\AdSchedule;
use Zairakai\LaravelTwitch\Dto\Ads\AdSnooze;
use Zairakai\LaravelTwitch\Dto\Analytics\ExtensionAnalytics;
use Zairakai\LaravelTwitch\Dto\Analytics\GameAnalytics;
use Zairakai\LaravelTwitch\Dto\ChannelPoints\CustomReward;
use Zairakai\LaravelTwitch\Dto\ChannelPoints\Redemption;
use Zairakai\LaravelTwitch\Dto\Chat\ChatSettings;
use Zairakai\LaravelTwitch\Dto\Chat\Emote;
use Zairakai\LaravelTwitch\Dto\Chat\PinnedChatMessage;
use Zairakai\LaravelTwitch\Dto\Chat\SharedChatSession;
use Zairakai\LaravelTwitch\Dto\Drops\DropsEntitlement;
use Zairakai\LaravelTwitch\Dto\GuestStar\GuestStarInvite;
use Zairakai\LaravelTwitch\Dto\Predictions\Outcome;
use Zairakai\LaravelTwitch\Dto\Streams\StreamKey;
use Zairakai\LaravelTwitch\Dto\Streams\StreamMarker;
use Zairakai\LaravelTwitch\Dto\Teams\Team;
use Zairakai\LaravelTwitch\Dto\Users\Follower;
use Zairakai\LaravelTwitch\Dto\Users\SubscriptionCheck;
use Zairakai\LaravelTwitch\Tests\TestCase;

/**
 * Payload shapes seen on the real Twitch API (2026-11-20) that the DTOs used to refuse.
 */
final class RealPayloadShapesTest extends TestCase
{
    #[Test]
    public function it_accepts_prediction_outcomes_without_top_predictors(): void
    {
        $outcome = Outcome::from([
            'id'             => 'o1',
            'title'          => 'Yes',
            'channel_points' => 0,
            'users'          => 0,
            'color'          => 'BLUE',
            'top_predictors' => null,
        ]);

        self::assertNull($outcome->topPredictors);
    }

    #[Test]
    public function it_reads_a_date_with_fractional_seconds(): void
    {
        // Twitch sends microseconds on some dates; the default Spatie cast only accepts Y-m-d\TH:i:sP.
        $follower = Follower::from([
            'user_id'     => '1',
            'user_login'  => 'someone',
            'user_name'   => 'Someone',
            'followed_at' => '2026-06-13T15:39:04.994955Z',
        ]);

        self::assertInstanceOf(Carbon::class, $follower->followedAt);
        self::assertSame('2026-06-13 15:39:04', $follower->followedAt->utc()->format('Y-m-d H:i:s'));
    }

    #[Test]
    public function it_reads_a_guest_star_invite_as_twitch_sends_it(): void
    {
        $invite = GuestStarInvite::from([
            'user_id'            => '1',
            'invited_at'         => '2026-11-20T10:00:00Z',
            'status'             => 'INVITED',
            'is_video_enabled'   => true,
            'is_audio_enabled'   => false,
            'is_video_available' => true,
            'is_audio_available' => true,
        ]);

        self::assertSame('INVITED', $invite->status);
        self::assertTrue($invite->isVideoAvailable);
        self::assertFalse($invite->isAudioEnabled);
        self::assertNull($invite->userLogin);
    }

    #[Test]
    public function it_reads_a_pinned_message_without_a_message_body_and_without_an_end(): void
    {
        $pin = PinnedChatMessage::from([
            'message_id'            => 'm1',
            'broadcaster_id'        => '1',
            'sender_user_id'        => '2',
            'sender_user_login'     => 'u',
            'sender_user_name'      => 'U',
            'pinned_by_user_id'     => '3',
            'pinned_by_user_login'  => 'm',
            'pinned_by_user_name'   => 'M',
            'message'               => null,
            'starts_at'             => '2026-11-20T10:00:00.123Z',
            'ends_at'               => null,
            'updated_at'            => '2026-11-20T10:00:01Z',
        ]);

        self::assertNull($pin->message);
        self::assertNull($pin->endsAt);
        self::assertSame('2026-11-20 10:00:00', $pin->startsAt->utc()->format('Y-m-d H:i:s'));
    }

    #[Test]
    public function it_reads_a_shared_chat_session_as_twitch_sends_it(): void
    {
        // The session has the host ID and the participant IDs only (no login, no name), and two dates.
        $session = SharedChatSession::from([
            'session_id'          => 's1',
            'host_broadcaster_id' => '1',
            'participants'        => [
                [
                    'broadcaster_id' => '1',
                ],
                [
                    'broadcaster_id' => '2',
                ],
            ],
            'created_at'          => '2026-11-20T10:00:00.123456Z',
            'updated_at'          => '2026-11-20T10:05:00Z',
        ]);

        self::assertSame('1', $session->hostBroadcasterId);
        self::assertCount(2, $session->participants);
        self::assertInstanceOf(Carbon::class, $session->createdAt);
        self::assertNull($session->hostBroadcasterLogin);
    }

    #[Test]
    public function it_reads_a_stream_key_without_the_broadcaster(): void
    {
        // Get Stream Key answers `stream_key` only.
        $streamKey = StreamKey::from([
            'stream_key' => 'live_123_abc',
        ]);

        self::assertSame('live_123_abc', $streamKey->streamKey);
        self::assertNull($streamKey->broadcasterId);
    }

    #[Test]
    public function it_reads_a_team_of_a_channel(): void
    {
        $team = Team::from([
            'broadcaster_id'       => '1',
            'broadcaster_login'    => 'b',
            'broadcaster_name'     => 'B',
            'background_image_url' => null,
            'banner'               => null,
            'created_at'           => '2026-01-01T00:00:00Z',
            'updated_at'           => null,
            'info'                 => 'Info',
            'thumbnail_url'        => null,
            'team_name'            => 'team',
            'team_display_name'    => 'Team',
            'id'                   => '9',
        ]);

        self::assertSame('1', $team->broadcasterId);
        self::assertNull($team->updatedAt);
    }

    #[Test]
    public function it_reads_a_user_emote_without_images(): void
    {
        // Get User Emotes gives a template, not the images list.
        $emote = Emote::from([
            'id'           => 'emotesv2_abc',
            'name'         => 'LUL',
            'format'       => [
                'static',
            ],
            'scale'        => [
                '1.0',
                '2.0',
                '3.0',
            ],
            'theme_mode'   => [
                'dark',
                'light',
            ],
            'emote_type'   => 'follower',
            'emote_set_id' => '300',
            'owner_id'     => '1',
        ]);

        self::assertSame([], $emote->images);
        self::assertSame('follower', $emote->emoteType);
    }

    #[Test]
    public function it_reads_an_ad_snooze_without_the_broadcaster(): void
    {
        $snooze = AdSnooze::from([
            'snooze_count'      => 2,
            'snooze_refresh_at' => 1_781_000_000,
            'next_ad_at'        => 1_781_000_300,
        ]);

        self::assertSame(2, $snooze->snoozeCount);
        self::assertNull($snooze->broadcasterId);
        self::assertSame(1_781_000_300, $snooze->nextAdAt?->getTimestamp());
    }

    #[Test]
    public function it_reads_the_ad_schedule_dates_given_as_unix_seconds(): void
    {
        // Get Ad Schedule sends Unix seconds, and 0 for "none": the DTO threw CannotCastDate on `0`.
        $adSchedule = AdSchedule::from([
            'duration'          => 60,
            'snooze_count'      => 3,
            'preroll_free_time' => 0,
            'next_ad_at'        => 1_781_000_000,
            'last_ad_at'        => 0,
            'snooze_refresh_at' => 0,
        ]);

        self::assertInstanceOf(Carbon::class, $adSchedule->nextAdAt);
        self::assertSame(1_781_000_000, $adSchedule->nextAdAt->getTimestamp());
        self::assertNull($adSchedule->lastAdAt);
        self::assertNull($adSchedule->snoozeRefreshAt);
    }

    #[Test]
    public function it_reads_the_custom_reward_limits_as_objects(): void
    {
        $customReward = CustomReward::from([
            'broadcaster_id'                         => '1',
            'broadcaster_login'                      => 'someone',
            'broadcaster_name'                       => 'Someone',
            'id'                                     => 'r1',
            'title'                                  => 'Hydrate',
            'prompt'                                 => '',
            'cost'                                   => 100,
            'background_color'                       => '#9147FF',
            'is_enabled'                             => true,
            'is_user_input_required'                 => false,
            'is_paused'                              => false,
            'is_in_stock'                            => true,
            'should_redemptions_skip_request_queue'  => false,
            'max_per_stream_setting'                 => [
                'is_enabled'     => true,
                'max_per_stream' => 5,
            ],
            'max_per_user_per_stream_setting'        => [
                'is_enabled'              => false,
                'max_per_user_per_stream' => 0,
            ],
            'global_cooldown_setting'                => [
                'is_enabled'              => true,
                'global_cooldown_seconds' => 60,
            ],
        ]);

        self::assertSame([
            'is_enabled'     => true,
            'max_per_stream' => 5,
        ], $customReward->maxPerStreamSetting);
        self::assertSame([
            'is_enabled'              => true,
            'global_cooldown_seconds' => 60,
        ], $customReward->globalCooldownSetting);
    }

    #[Test]
    public function it_reads_the_gifter_id_of_a_subscription(): void
    {
        $check = SubscriptionCheck::from([
            'broadcaster_id'    => '1',
            'broadcaster_login' => 'b',
            'broadcaster_name'  => 'B',
            'gifter_id'         => '2',
            'gifter_login'      => 'g',
            'gifter_name'       => 'G',
            'is_gift'           => true,
            'tier'              => '1000',
        ]);

        self::assertSame('2', $check->gifterId);
    }

    #[Test]
    public function it_reads_the_last_updated_date_of_a_drop_entitlement(): void
    {
        $drop = DropsEntitlement::from([
            'id'                 => 'd1',
            'benefit_id'         => 'b1',
            'timestamp'          => '2026-11-20T10:00:00.1Z',
            'user_id'            => '1',
            'game_id'            => '2',
            'fulfillment_status' => 'CLAIMED',
            'last_updated'       => '2026-11-20T11:00:00Z',
        ]);

        self::assertInstanceOf(Carbon::class, $drop->lastUpdated);
    }

    #[Test]
    public function it_reads_the_moderator_of_the_chat_settings(): void
    {
        $settings = ChatSettings::from([
            'broadcaster_id'                     => '1',
            'moderator_id'                       => '2',
            'emote_mode'                         => false,
            'follower_mode'                      => false,
            'follower_mode_duration'             => null,
            'slow_mode'                          => false,
            'slow_mode_wait_time'                => null,
            'subscriber_mode'                    => false,
            'unique_chat_mode'                   => false,
            'non_moderator_chat_delay'           => false,
            'non_moderator_chat_delay_duration'  => null,
        ]);

        self::assertSame('2', $settings->moderatorId);
    }

    #[Test]
    public function it_reads_the_owner_of_a_user_emote(): void
    {
        $emote = Emote::from([
            'id'           => 'e1',
            'name'         => 'Kappa',
            'emote_type'   => 'follower',
            'emote_set_id' => '300',
            'owner_id'     => '12826',
            'format'       => [
                'static',
            ],
            'scale'        => [
                '1.0',
            ],
            'theme_mode'   => [
                'dark',
            ],
        ]);

        self::assertSame('12826', $emote->ownerId);
    }

    #[Test]
    public function it_reads_the_reward_object_of_a_redemption(): void
    {
        $redemption = Redemption::from([
            'broadcaster_id'    => '1',
            'broadcaster_login' => 'b',
            'broadcaster_name'  => 'B',
            'id'                => 'red-1',
            'user_id'           => '2',
            'user_login'        => 'u',
            'user_name'         => 'U',
            'user_input'        => 'hello',
            'status'            => 'UNFULFILLED',
            'redeemed_at'       => '2026-11-20T10:00:00.5Z',
            'reward'            => [
                'id'     => 'r1',
                'title'  => 'Hydrate',
                'prompt' => 'Drink',
                'cost'   => 100,
            ],
        ]);

        self::assertSame('r1', $redemption->rewardId);
        self::assertSame('Hydrate', $redemption->rewardTitle);
        self::assertSame(100, $redemption->rewardCost);
        self::assertSame([
            'id'     => 'r1',
            'title'  => 'Hydrate',
            'prompt' => 'Drink',
            'cost'   => 100,
        ], $redemption->reward);
    }

    #[Test]
    public function it_reads_the_url_key_of_a_stream_marker(): void
    {
        $marker = StreamMarker::from([
            'id'               => 'mk1',
            'created_at'       => '2026-11-20T10:00:00Z',
            'description'      => 'x',
            'position_seconds' => 12,
            'URL'              => 'https://www.twitch.tv/videos/1?t=0h0m12s',
        ]);

        self::assertSame('https://www.twitch.tv/videos/1?t=0h0m12s', $marker->url);
    }

    #[Test]
    public function it_reads_the_url_key_of_the_analytics_reports(): void
    {
        // Twitch names the field `URL` (uppercase).
        $extension = ExtensionAnalytics::from([
            'extension_id' => 'e1',
            'URL'          => 'https://example.com/e.csv',
            'type'         => 'overview_v2',
            'date_range'   => [
                'started_at' => '2026-01-01T00:00:00Z',
                'ended_at'   => '2026-01-02T00:00:00Z',
            ],
        ]);
        $game      = GameAnalytics::from([
            'game_id'    => '1',
            'URL'        => 'https://example.com/g.csv',
            'type'       => 'overview_v2',
            'date_range' => [],
        ]);

        self::assertSame('https://example.com/e.csv', $extension->url);
        self::assertSame('https://example.com/g.csv', $game->url);
    }
}
