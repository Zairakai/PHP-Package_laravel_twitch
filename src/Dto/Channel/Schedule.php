<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Channel;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents a broadcaster's stream schedule.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-channel-stream-schedule
 */
#[MapInputName(SnakeCaseMapper::class)]
class Schedule extends TwitchData
{
    public function __construct(
        /**
         * @var string Broadcaster ID
         */
        public string $broadcasterId,

        /**
         * @var DataCollection<int, ScheduleSegment> Schedule segments (none when nothing is planned)
         */
        #[DataCollectionOf(ScheduleSegment::class)]
        public DataCollection $segments,

        /**
         * @var string|null Broadcaster name (null for a schedule that does not exist: Twitch gives nothing then)
         */
        public ?string $broadcasterName = null,

        /**
         * @var string|null Broadcaster login (lowercase; null for a schedule that does not exist)
         */
        public ?string $broadcasterLogin = null,

        /**
         * @var array{start_time: string, end_time: string}|null
         *                                                       Vacation period info (if broadcaster is on vacation)
         */
        public ?array $vacation = null,
    ) {}

    /**
     * The schedule of a broadcaster who has planned nothing: no segment, no vacation.
     */
    public static function none(string $broadcasterId): self
    {
        /** @var DataCollection<int, ScheduleSegment> $segments */
        $segments = ScheduleSegment::collect([], DataCollection::class);

        return new self($broadcasterId, $segments);
    }
}
