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
 * Payload of a `channel.goal.end` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelgoalend
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelGoalEndEvent extends TwitchData implements EventSubEvent
{
    public function __construct(
        public string $id,
        public string $broadcasterUserId,
        public string $broadcasterUserName,
        public string $broadcasterUserLogin,
        public string $type,
        /**
         * @var string|null Goal description shown to viewers - null when the
         *                  goal has no description configured
         */
        public ?string $description,
        public bool $isAchieved,
        public int $currentAmount,
        public int $targetAmount,
        #[WithCast(FlexibleDateTimeCast::class)]
        public Carbon $startedAt,
        #[WithCast(FlexibleDateTimeCast::class)]
        public Carbon $endedAt,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->broadcasterUserId;
    }
}
