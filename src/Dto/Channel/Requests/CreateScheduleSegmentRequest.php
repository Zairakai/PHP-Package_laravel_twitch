<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Channel\Requests;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Request DTO for adding a segment to a broadcaster's streaming schedule.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#create-channel-stream-schedule-segment
 */
#[MapOutputName(SnakeCaseMapper::class)]
class CreateScheduleSegmentRequest extends Data
{
    public function __construct(
        /**
         * @var string Start time of the segment (RFC3339 format, e.g. 2023-07-01T18:00:00Z)
         */
        public readonly string $startTime,

        /**
         * @var string IANA timezone of the broadcaster (e.g. America/New_York)
         */
        public readonly string $timezone,

        /**
         * @var int Duration of the segment in minutes
         */
        public readonly int $duration,

        /**
         * @var bool Whether this segment recurs weekly
         */
        public readonly bool $isRecurring,

        /**
         * @var string|null Category ID for this segment
         */
        public readonly ?string $categoryId = null,

        /**
         * @var string|null Segment title (max 140 chars)
         */
        public readonly ?string $title = null,
    ) {}
}
