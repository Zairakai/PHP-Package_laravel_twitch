<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload shared by `channel.channel_points_custom_reward_redemption.add` and
 * `.update` EventSub notifications - identical shape, `status` differs
 * (unfulfilled on add; fulfilled or canceled on update).
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelchannel_points_custom_reward_redemptionadd
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelPointsRedemptionEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $id,
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public string $userId,
        public string $userLogin,
        public string $userName,

        /**
         * @var string unfulfilled, fulfilled or canceled
         */
        public string $status,
        public ChannelPointsReward $reward,

        /**
         * @var string RFC3339 timestamp - kept as a raw string, see ChannelFollowEvent::$followedAt
         *             for why this isn't cast to Carbon
         */
        public string $redeemedAt,

        /**
         * @var string|null Text the user typed if the reward required input
         */
        public ?string $userInput = null,
    ) {}
}
