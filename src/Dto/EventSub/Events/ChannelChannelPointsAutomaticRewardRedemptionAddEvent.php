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
 * Payload of a `channel.channel_points_automatic_reward_redemption.add` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelchannel_points_automatic_reward_redemptionadd
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelChannelPointsAutomaticRewardRedemptionAddEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $broadcasterUserId,
        public string $broadcasterUserName,
        public string $broadcasterUserLogin,
        public string $userId,
        public string $userName,
        public string $userLogin,
        public string $id,

        /**
         * @var array<string, mixed>
         */
        public array $reward,

        /**
         * @var array<string, mixed>
         */
        public array $message,
        public string $userInput,
        #[WithCast(FlexibleDateTimeCast::class)]
        public Carbon $redeemedAt,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->broadcasterUserId;
    }
}
