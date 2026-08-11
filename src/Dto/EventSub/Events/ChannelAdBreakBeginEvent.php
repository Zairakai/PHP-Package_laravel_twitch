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
 * Payload of a `channel.ad_break.begin` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelad_breakbegin
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelAdBreakBeginEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $durationSeconds,
        #[WithCast(FlexibleDateTimeCast::class)]
        public Carbon $startedAt,
        public string $isAutomatic,
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public string $requesterUserId,
        public string $requesterUserLogin,
        public string $requesterUserName,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->broadcasterUserId;
    }
}
