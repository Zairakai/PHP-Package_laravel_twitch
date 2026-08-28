<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\EventSub;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\GenericEventSubEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\EventSubEventFactory;
use Zairakai\LaravelTwitch\Tests\TestCase;

/**
 * Round-trips every mapped EventSub type through the factory using the exact
 * example payload published on dev.twitch.tv/docs/eventsub/eventsub-subscription-types
 * (fetched 2026-08-09) - proves each generated DTO actually constructs from a
 * real Twitch payload, not just that it compiles.
 */
final class EventSubEventFactoryRealPayloadsTest extends TestCase
{
    /**
     * @return iterable<string, array{0: string}>
     */
    public static function mappedTypes(): iterable
    {
        /** @var array<string, string> $fixtures */
        $fixtures = require __DIR__ . '/../../../Fixtures/eventsub_examples.php';

        foreach (array_keys($fixtures) as $type) {
            yield $type => [$type];
        }
    }

    /**
     * Charity campaign types using the non-standard `broadcaster_id` field
     * (Twitch's own docs inconsistency) - `channel.charity_campaign.donate`
     * is not one of them, it uses the standard `broadcaster_user_id`.
     *
     * @return list<string>
     */
    public static function typesWithBroadcasterIdField(): array
    {
        return [
            'channel.charity_campaign.start',
            'channel.charity_campaign.progress',
            'channel.charity_campaign.stop',
        ];
    }

    /**
     * Types with no single channel owner - user-scoped or app-scoped
     * notifications where getBroadcasterUserId() is expected to return null.
     *
     * @return list<string>
     */
    public static function typesWithNoBroadcaster(): array
    {
        return [
            'conduit.shard.disabled',
            'user.authorization.grant',
            'user.authorization.revoke',
            'user.update',
            'user.whisper.message',
        ];
    }

    /**
     * Regression test for a real production crash (2026-08-27, live stream,
     * caught alongside the null-prompt one above but not fixed until
     * 2026-08-28): a reward with no custom image configured sends
     * `"image": null`, falling back to `default_image`. `$image` used to be
     * typed non-nullable `array`, crashing add/update/remove notifications
     * (and any redemption, via the embedded reward) the same way the
     * null-prompt bug did.
     */
    #[Test]
    public function it_accepts_a_null_image_on_channel_points_custom_reward_update(): void
    {
        $payload = [
            'id'                                        => '9001',
            'broadcaster_user_id'                       => '1337',
            'broadcaster_user_login'                    => 'cool_user',
            'broadcaster_user_name'                     => 'Cool_User',
            'is_enabled'                                => true,
            'is_paused'                                 => false,
            'is_in_stock'                               => true,
            'title'                                     => 'Reward with no custom image',
            'cost'                                      => 150,
            'prompt'                                    => 'Random',
            'is_user_input_required'                    => false,
            'should_redemptions_skip_request_queue'     => true,
            'cooldown_expires_at'                       => null,
            'redemptions_redeemed_current_stream'       => null,
            'max_per_stream'                            => ['is_enabled' => false, 'value' => 0],
            'max_per_user_per_stream'                   => ['is_enabled' => false, 'value' => 0],
            'global_cooldown'                           => ['is_enabled' => true, 'seconds' => 300],
            'background_color'                          => '#F9D793',
            'image'                                     => null,
            'default_image'                             => [
                'url_1x' => 'https://static-cdn.jtvnw.net/custom-reward-images/default-1.png',
                'url_2x' => 'https://static-cdn.jtvnw.net/custom-reward-images/default-2.png',
                'url_4x' => 'https://static-cdn.jtvnw.net/custom-reward-images/default-4.png',
            ],
        ];

        $eventSubEvent = EventSubEventFactory::make('channel.channel_points_custom_reward.update', $payload);

        $this->assertNotInstanceOf(GenericEventSubEvent::class, $eventSubEvent);
        $this->assertNull($eventSubEvent->image);
    }

    #[Test]
    public function it_accepts_a_null_prompt_on_a_redeemed_reward(): void
    {
        $payload = [
            'id'                     => '17fa2df1-ad76-4804-bfa5-a40ef63efe63',
            'broadcaster_user_id'    => '1337',
            'broadcaster_user_login' => 'cool_user',
            'broadcaster_user_name'  => 'Cool_User',
            'user_id'                => '9001',
            'user_login'             => 'cooler_user',
            'user_name'              => 'Cooler_User',
            'user_input'             => '',
            'status'                 => 'unfulfilled',
            'reward'                 => [
                'id'     => '92af127c-7326-4483-a52b-b0da0be61c01',
                'title'  => 'Reward with no prompt',
                'cost'   => 100,
                'prompt' => null,
            ],
            'redeemed_at' => '2026-08-27T18:00:00Z',
        ];

        $eventSubEvent = EventSubEventFactory::make('channel.channel_points_custom_reward_redemption.add', $payload);

        $this->assertNotInstanceOf(GenericEventSubEvent::class, $eventSubEvent);
        $this->assertNull($eventSubEvent->reward->prompt);
    }

    /**
     * Regression test for a real production crash (2026-08-27, live stream):
     * Twitch's own docs example always shows a non-empty `prompt` string for
     * channel points rewards, but a real reward configured with no prompt
     * text sends `"prompt": null` - the fixture above never exercised this,
     * only the always-populated example. `$prompt` used to be typed
     * non-nullable `string`, crashing every update/add/remove notification
     * (and every redemption of such a reward, via the embedded
     * ChannelPointsReward) with a TypeError, 500ing the webhook and losing
     * the event - Twitch retried and kept losing it until this was caught
     * and fixed live.
     */
    #[Test]
    public function it_accepts_a_null_prompt_on_channel_points_custom_reward_update(): void
    {
        $payload = [
            'id'                                      => '9001',
            'broadcaster_user_id'                     => '1337',
            'broadcaster_user_login'                  => 'cool_user',
            'broadcaster_user_name'                   => 'Cool_User',
            'is_enabled'                              => true,
            'is_paused'                               => false,
            'is_in_stock'                             => true,
            'title'                                   => 'Reward with no prompt',
            'cost'                                    => 100,
            'prompt'                                  => null,
            'is_user_input_required'                  => false,
            'should_redemptions_skip_request_queue'   => false,
            'cooldown_expires_at'                     => null,
            'redemptions_redeemed_current_stream'     => null,
            'max_per_stream'                          => ['is_enabled' => false, 'value' => 0],
            'max_per_user_per_stream'                 => ['is_enabled' => false, 'value' => 0],
            'global_cooldown'                         => ['is_enabled' => false, 'seconds' => 0],
            'background_color'                        => '#4A90D9',
            'image'                                   => [],
            'default_image'                           => [],
        ];

        $eventSubEvent = EventSubEventFactory::make('channel.channel_points_custom_reward.update', $payload);

        $this->assertNotInstanceOf(GenericEventSubEvent::class, $eventSubEvent);
        $this->assertNull($eventSubEvent->prompt);
    }

    /**
     * Regression test for a real production crash (2026-08-27, live stream,
     * caught but not fixed until 2026-08-28): `channel.chat.notification`
     * with `notice_type: watch_streak` carries an empty `message.text` (no
     * user-typed comment alongside the system notice) and a `watch_streak`
     * object shaped `{streak_count, channel_points_awarded}` - not the
     * `{watch_streak_months}` this package's DTO invented from documentation
     * without ever independently verifying it. Both crashed: `Message::$text`
     * was non-nullable `string`, and `ChatNotificationWatchStreak` expected a
     * constructor argument that was never actually sent.
     */
    #[Test]
    public function it_accepts_a_watch_streak_chat_notification(): void
    {
        $payload = [
            'broadcaster_user_id'    => '1337',
            'broadcaster_user_login' => 'cool_user',
            'broadcaster_user_name'  => 'Cool_User',
            'chatter_user_id'        => '9001',
            'chatter_user_login'     => 'cooler_user',
            'chatter_user_name'      => 'Cooler_User',
            'chatter_is_anonymous'   => false,
            'color'                  => '#FF69B4',
            'badges'                 => [],
            'system_message'         => 'cooler_user watched 10 consecutive streams and sparked a watch streak!',
            'message_id'             => 'watch-streak-message-id',
            'message'                => ['text' => null, 'fragments' => []],
            'notice_type'            => 'watch_streak',
            'watch_streak'           => ['streak_count' => 10, 'channel_points_awarded' => 450],
        ];

        $eventSubEvent = EventSubEventFactory::make('channel.chat.notification', $payload);

        $this->assertNotInstanceOf(GenericEventSubEvent::class, $eventSubEvent);
        $this->assertNull($eventSubEvent->message->text);
        $this->assertNotNull($eventSubEvent->watchStreak);
        $this->assertSame(10, $eventSubEvent->watchStreak->streakCount);
        $this->assertSame(450, $eventSubEvent->watchStreak->channelPointsAwarded);
    }

    /**
     * Regression test for a real production crash (2026-08-27, live stream,
     * caught but not fixed until 2026-08-28): `automod.message.update` used
     * a flat message/level/category/fragments shape generated from Twitch's
     * docs example and never independently verified - the real payload uses
     * the same v2 shape as `automod.message.hold` (message.{text,fragments},
     * reason/automod/blocked_term discriminator) plus moderator identity and
     * a resolution `status`.
     */
    #[Test]
    public function it_accepts_the_real_shape_of_automod_message_update(): void
    {
        $payload = [
            'broadcaster_user_id'    => '1337',
            'broadcaster_user_login' => 'cool_user',
            'broadcaster_user_name'  => 'Cool_User',
            'user_id'                => '9001',
            'user_login'             => 'bad_user',
            'user_name'              => 'Bad_User',
            'moderator_user_id'      => '5678',
            'moderator_user_login'   => 'the_mod',
            'moderator_user_name'    => 'The_Mod',
            'message_id'             => 'bad-message-id',
            'message'                => [
                'text'      => 'held message text',
                'fragments' => [],
            ],
            'reason'       => 'automod',
            'status'       => 'approved',
            'automod'      => ['category' => 'namecalling', 'level' => 2, 'boundaries' => []],
            'blocked_term' => null,
            'held_at'      => '2026-08-27T18:00:00Z',
        ];

        $eventSubEvent = EventSubEventFactory::make('automod.message.update', $payload);

        $this->assertNotInstanceOf(GenericEventSubEvent::class, $eventSubEvent);
        $this->assertSame('held message text', $eventSubEvent->message->text);
        $this->assertSame('approved', $eventSubEvent->status);
        $this->assertSame('namecalling', $eventSubEvent->automod['category']);
        $this->assertNull($eventSubEvent->blockedTerm);
    }

    #[Test]
    #[DataProvider('mappedTypes')]
    public function it_constructs_the_mapped_dto_from_the_official_example_payload(string $type): void
    {
        /** @var array<string, string> $fixtures */
        $fixtures = require __DIR__ . '/../../../Fixtures/eventsub_examples.php';

        $raw = $fixtures[$type];

        // Strip the // comments Twitch's docs embed in their JSON examples, and
        // the trailing commas that removing them leaves behind.
        $cleaned = preg_replace('/(?<=\s)\/\/[^\n]*/', '', $raw);
        $cleaned = preg_replace('/,(\s*[}\]])/', '$1', (string) $cleaned);

        /** @var array<string, mixed>|null $payload */
        $payload = json_decode((string) $cleaned, true);

        $this->assertIsArray($payload, "Fixture for {$type} is not valid JSON once cleaned.");

        $event = EventSubEventFactory::make($type, $payload);

        $this->assertNotInstanceOf(
            GenericEventSubEvent::class,
            $event,
            "{$type} is expected to resolve to a dedicated DTO, not the generic fallback.",
        );
    }

    #[Test]
    public function it_falls_back_to_generic_event_for_a_type_with_no_dedicated_dto(): void
    {
        $eventSubEvent = EventSubEventFactory::make('channel.some_future_type', ['id' => '1']);

        $this->assertInstanceOf(GenericEventSubEvent::class, $eventSubEvent);
    }

    #[Test]
    #[DataProvider('mappedTypes')]
    public function it_resolves_the_expected_broadcaster_user_id_for_each_type(string $type): void
    {
        /** @var array<string, string> $fixtures */
        $fixtures = require __DIR__ . '/../../../Fixtures/eventsub_examples.php';

        $cleaned = preg_replace('/(?<=\s)\/\/[^\n]*/', '', $fixtures[$type]);
        $cleaned = preg_replace('/,(\s*[}\]])/', '$1', (string) $cleaned);

        /** @var array<string, mixed> $payload */
        $payload = json_decode((string) $cleaned, true);

        $event = EventSubEventFactory::make($type, $payload);

        $expected = match (true) {
            in_array($type, self::typesWithNoBroadcaster(), true)      => null,
            'channel.raid' === $type                                   => $payload['to_broadcaster_user_id'],
            in_array($type, self::typesWithBroadcasterIdField(), true) => $payload['broadcaster_id'],
            'automod.settings.update' === $type                        => $payload['data'][0]['broadcaster_user_id'],
            default                                                    => $payload['broadcaster_user_id'] ?? null,
        };

        $this->assertSame(
            $expected,
            $event->getBroadcasterUserId(),
            "Unexpected getBroadcasterUserId() for {$type}.",
        );
    }
}
