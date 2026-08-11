<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;

/**
 * Payload of a `channel.channel_points_custom_reward.remove` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelchannel_points_custom_rewardremove
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelChannelPointsCustomRewardRemoveEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $id,
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public bool $isEnabled,
        public bool $isPaused,
        public bool $isInStock,
        public string $title,
        public int $cost,
        public string $prompt,
        public bool $isUserInputRequired,
        public bool $shouldRedemptionsSkipRequestQueue,
        public RewardLimitSetting $maxPerStream,
        public RewardLimitSetting $maxPerUserPerStream,
        public RewardCooldownSetting $globalCooldown,
        public string $backgroundColor,

        /**
         * @var array<string, mixed>
         */
        public array $image,

        /**
         * @var array<string, mixed>
         */
        public array $defaultImage,

        /**
         * @var Carbon|null When the global cooldown expires - null when the reward has no active cooldown
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $cooldownExpiresAt = null,

        /**
         * @var int|null Number of redemptions during the current stream - null outside a live stream
         */
        public ?int $redemptionsRedeemedCurrentStream = null,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->broadcasterUserId;
    }
}
