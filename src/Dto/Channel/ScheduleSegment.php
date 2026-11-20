<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Channel;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents a single segment in a broadcaster's stream schedule.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-channel-stream-schedule
 */
#[MapInputName(SnakeCaseMapper::class)]
class ScheduleSegment extends TwitchData
{
    public function __construct(
        /**
         * @var string Segment ID
         */
        public string $id,

        /**
         * @var string Segment title
         */
        public string $title,

        /**
         * @var bool Whether this is a recurring segment
         */
        public bool $isRecurring,

        /**
         * @var Carbon|null When the segment starts
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $startTime = null,

        /**
         * @var Carbon|null When the segment ends
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $endTime = null,

        /**
         * @var Carbon|null If vacation, when segments resume
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $canceledUntil = null,

        /**
         * @var array{id: string, name: string}|null Game/category for this segment
         */
        public ?array $category = null,
    ) {}
}
