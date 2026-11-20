<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Payload of a `channel.channel_points_automatic_reward_redemption.add` EventSub notification (v1 and v2).
 *
 * `reward` differs between the versions: v1 has `type`, `cost` and `unlocked_emote`; v2 has `type`, `channel_points`
 * and `emote`.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelchannel_points_automatic_reward_redemptionadd
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelChannelPointsAutomaticRewardRedemptionAddEvent extends TwitchData implements EventSubEvent
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
        #[WithCast(FlexibleDateTimeCast::class)]
        public Carbon $redeemedAt,

        /**
         * @var array<string, mixed>|null v1: {text, emotes}; v2: {text, fragments}, and null when there is no message
         */
        public ?array $message = null,

        /**
         * @var string|null v1 only (absent from v2)
         */
        public ?string $userInput = null,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->broadcasterUserId;
    }
}
