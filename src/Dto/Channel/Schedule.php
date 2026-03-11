<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Channel;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a broadcaster's stream schedule.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-channel-stream-schedule
 */
#[MapInputName(SnakeCaseMapper::class)]
class Schedule extends Data
{
    public function __construct(
        /**
         * @var string Broadcaster ID
         */
        public string $broadcasterId,

        /**
         * @var string Broadcaster name
         */
        public string $broadcasterName,

        /**
         * @var string Broadcaster login (lowercase)
         */
        public string $broadcasterLogin,

        /**
         * @var DataCollection<int, ScheduleSegment> Schedule segments
         */
        #[DataCollectionOf(ScheduleSegment::class)]
        public DataCollection $segments,

        /**
         * @var array{start_time: string, end_time: string}|null
         *                                                       Vacation period info (if broadcaster is on vacation)
         */
        public ?array $vacation = null,
    ) {}
}
