<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\EventSub;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\AutomodMessageHoldEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\AutomodMessageUpdateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChannelPointsAutomaticRewardRedemptionAddEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelModerateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\EventSubEventFactory;
use Zairakai\LaravelTwitch\Support\EventSubTypes;
use Zairakai\LaravelTwitch\Tests\TestCase;

/**
 * The payload of some types depends on the version of the subscription: both versions must be read.
 */
final class EventSubVersionsTest extends TestCase
{
    #[Test]
    public function it_gives_the_latest_version_of_a_type_as_the_default(): void
    {
        self::assertSame('2', EventSubTypes::defaultVersion('channel.follow'));
        self::assertSame('2', EventSubTypes::defaultVersion('channel.update'));
        self::assertSame('2', EventSubTypes::defaultVersion('channel.hype_train.begin'));
        self::assertSame('2', EventSubTypes::defaultVersion('automod.message.hold'));
        self::assertSame('1', EventSubTypes::defaultVersion('stream.online'));
        self::assertSame('1', EventSubTypes::defaultVersion('a.type.twitch.adds.later'));
        self::assertTrue(EventSubTypes::isBatched('drop.entitlement.grant'));
        self::assertFalse(EventSubTypes::isBatched('stream.online'));
    }

    #[Test]
    public function it_reads_an_automatic_reward_redemption_v1_and_v2(): void
    {
        $common = [
            'id'                     => 'r1',
            'broadcaster_user_id'    => '1',
            'broadcaster_user_login' => 'b',
            'broadcaster_user_name'  => 'B',
            'user_id'                => '2',
            'user_login'             => 'u',
            'user_name'              => 'U',
            'redeemed_at'            => '2026-11-20T10:00:00.5Z',
        ];

        $v1 = EventSubEventFactory::make('channel.channel_points_automatic_reward_redemption.add', $common + [
            'reward'     => [
                'type'           => 'send_highlighted_message',
                'cost'           => 100,
                'unlocked_emote' => null,
            ],
            'message'    => [
                'text'   => 'hi',
                'emotes' => [],
            ],
            'user_input' => 'hi',
        ]);
        // v2: no user_input, `reward.channel_points`, fragments, and a message that can be null.
        $v2 = EventSubEventFactory::make('channel.channel_points_automatic_reward_redemption.add', $common + [
            'reward'  => [
                'type'           => 'random_sub_emote_unlock',
                'channel_points' => 500,
                'emote'          => [
                    'id'   => 'e1',
                    'name' => 'Poggers',
                ],
            ],
            'message' => null,
        ]);

        self::assertInstanceOf(ChannelChannelPointsAutomaticRewardRedemptionAddEvent::class, $v1);
        self::assertSame('hi', $v1->userInput);
        self::assertInstanceOf(ChannelChannelPointsAutomaticRewardRedemptionAddEvent::class, $v2);
        self::assertNull($v2->userInput);
        self::assertNull($v2->message);
        self::assertSame(500, $v2->reward['channel_points']);
    }

    #[Test]
    public function it_reads_an_automod_message_hold_v1(): void
    {
        // v1 has category and level, no reason, and fragments without a `type`.
        $event = EventSubEventFactory::make('automod.message.hold', $this->hold() + [
            'message'  => [
                'text'      => 'hi cheer10',
                'fragments' => [
                    [
                        'text'      => 'hi ',
                        'emote'     => null,
                        'cheermote' => null,
                    ],
                    [
                        'text'      => 'cheer10',
                        'emote'     => null,
                        'cheermote' => [
                            'prefix' => 'cheer',
                            'bits'   => 10,
                            'tier'   => 1,
                        ],
                    ],
                    [
                        'text'  => 'Kappa',
                        'emote' => [
                            'id'           => '25',
                            'emote_set_id' => '0',
                        ],
                        'cheermote' => null,
                    ],
                ],
            ],
            'category' => 'aggressive',
            'level'    => 3,
        ]);

        self::assertInstanceOf(AutomodMessageHoldEvent::class, $event);
        self::assertSame('aggressive', $event->category);
        self::assertSame(3, $event->level);
        self::assertNull($event->reason);
        self::assertSame([
            'text',
            'cheermote',
            'emote',
        ], array_column($event->message->fragments->toArray(), 'type'));
    }

    #[Test]
    public function it_reads_an_automod_message_hold_v2(): void
    {
        $event = EventSubEventFactory::make('automod.message.hold', $this->hold() + [
            'message'      => [
                'text'      => 'hello',
                'fragments' => [
                    [
                        'type'      => 'text',
                        'text'      => 'hello',
                        'emote'     => null,
                        'cheermote' => null,
                    ],
                ],
            ],
            'reason'       => 'blocked_link',
            'automod'      => null,
            'blocked_term' => [
                'terms_found' => [],
            ],
        ]);

        self::assertInstanceOf(AutomodMessageHoldEvent::class, $event);
        self::assertSame('blocked_link', $event->reason);
        self::assertNull($event->category);
        self::assertNull($event->level);
    }

    #[Test]
    public function it_reads_an_automod_message_update_v1_and_v2(): void
    {
        $common = $this->hold() + [
            'moderator_user_id'    => '9',
            'moderator_user_login' => 'mod',
            'moderator_user_name'  => 'Mod',
            'status'               => 'Approved',
        ];

        $v1 = EventSubEventFactory::make('automod.message.update', $common + [
            'message'  => [
                'text'      => 'hi',
                'fragments' => [
                    [
                        'text'      => 'hi',
                        'emote'     => null,
                        'cheermote' => null,
                    ],
                ],
            ],
            'category' => 'swearing',
            'level'    => 2,
        ]);
        $v2 = EventSubEventFactory::make('automod.message.update', $common + [
            'message' => [
                'text'      => 'hi',
                'fragments' => [
                    [
                        'type'      => 'text',
                        'text'      => 'hi',
                        'emote'     => null,
                        'cheermote' => null,
                    ],
                ],
            ],
            'reason'  => 'automod',
            'automod' => [
                'category'   => 'swearing',
                'level'      => 2,
                'boundaries' => [
                    [
                        'start_pos' => 0,
                        'end_pos'   => 1,
                    ],
                ],
            ],
        ]);

        self::assertInstanceOf(AutomodMessageUpdateEvent::class, $v1);
        self::assertSame('swearing', $v1->category);
        self::assertInstanceOf(AutomodMessageUpdateEvent::class, $v2);
        self::assertSame('automod', $v2->reason);
    }

    #[Test]
    public function it_reads_the_warn_action_of_channel_moderate_v2(): void
    {
        $event = EventSubEventFactory::make('channel.moderate', [
            'broadcaster_user_id'    => '1',
            'broadcaster_user_login' => 'b',
            'broadcaster_user_name'  => 'B',
            'moderator_user_id'      => '9',
            'moderator_user_login'   => 'mod',
            'moderator_user_name'    => 'Mod',
            'action'                 => 'warn',
            'warn'                   => [
                'user_id'          => '2',
                'user_login'       => 'u',
                'user_name'        => 'U',
                'reason'           => 'be nice',
                'chat_rules_cited' => [
                    'rule 1',
                ],
            ],
        ]);

        self::assertInstanceOf(ChannelModerateEvent::class, $event);
        self::assertNotNull($event->warn);
        self::assertSame('be nice', $event->warn->reason);
        self::assertSame([
            'rule 1',
        ], $event->warn->chatRulesCited);
    }

    /**
     * @return array<string, mixed>
     */
    private function hold(): array
    {
        return [
            'broadcaster_user_id'    => '1',
            'broadcaster_user_login' => 'b',
            'broadcaster_user_name'  => 'B',
            'user_id'                => '2',
            'user_login'             => 'u',
            'user_name'              => 'U',
            'message_id'             => 'm1',
            'held_at'                => '2026-11-20T10:00:00.123456Z',
        ];
    }
}
