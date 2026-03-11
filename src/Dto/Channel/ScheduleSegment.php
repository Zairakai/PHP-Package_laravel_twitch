<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Channel;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a single segment in a broadcaster's stream schedule.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-channel-stream-schedule
 */
#[MapInputName(SnakeCaseMapper::class)]
class ScheduleSegment extends Data
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
        public ?Carbon $startTime = null,

        /**
         * @var Carbon|null When the segment ends
         */
        public ?Carbon $endTime = null,

        /**
         * @var Carbon|null If vacation, when segments resume
         */
        public ?Carbon $canceledUntil = null,

        /**
         * @var array{id: string, name: string}|null Game/category for this segment
         */
        public ?array $category = null,
    ) {}
}
