<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Ads;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents the ad schedule for a broadcaster's channel.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-ad-schedule
 */
#[MapInputName(SnakeCaseMapper::class)]
class AdSchedule extends TwitchData
{
    public function __construct(
        /**
         * @var int Duration of next ad in seconds
         */
        public int $duration,

        /**
         * @var int Number of snoozes available
         */
        public int $snoozeCount,

        /**
         * @var int Seconds before pre-roll is no longer shown
         */
        public int $prerollFreeTime,

        /**
         * @var Carbon|null When the next ad is scheduled
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $nextAdAt = null,

        /**
         * @var Carbon|null When the last ad ran
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $lastAdAt = null,

        /**
         * @var Carbon|null When the snooze refreshes
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $snoozeRefreshAt = null,
    ) {}
}
