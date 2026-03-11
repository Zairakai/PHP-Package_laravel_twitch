<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Channel\Requests;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Request DTO for updating a segment in a broadcaster's streaming schedule.
 *
 * All fields are optional — send only the ones you want to change.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#update-channel-stream-schedule-segment
 */
#[MapOutputName(SnakeCaseMapper::class)]
class UpdateScheduleSegmentRequest extends Data
{
    public function __construct(
        /**
         * @var string|null New start time (RFC3339)
         */
        public readonly ?string $startTime = null,

        /**
         * @var string|null IANA timezone (e.g. Europe/Paris)
         */
        public readonly ?string $timezone = null,

        /**
         * @var int|null New duration in minutes
         */
        public readonly ?int $duration = null,

        /**
         * @var string|null Category ID for this segment
         */
        public readonly ?string $categoryId = null,

        /**
         * @var string|null Segment title (max 140 chars)
         */
        public readonly ?string $title = null,

        /**
         * @var bool|null Cancel this occurrence of a recurring segment
         */
        public readonly ?bool $isCanceled = null,
    ) {}
}
