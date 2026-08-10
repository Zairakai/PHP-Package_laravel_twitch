<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `channel.channel_points_custom_reward.add` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelchannel_points_custom_rewardadd
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelChannelPointsCustomRewardAddEvent extends Data implements EventSubEvent
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

        /**
         * @var array<string, mixed>
         */
        public array $maxPerStream,

        /**
         * @var array<string, mixed>
         */
        public array $maxPerUserPerStream,

        /**
         * @var array<string, mixed>
         */
        public array $globalCooldown,
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
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $cooldownExpiresAt = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $redemptionsRedeemedCurrentStream = null,
    ) {}
}
