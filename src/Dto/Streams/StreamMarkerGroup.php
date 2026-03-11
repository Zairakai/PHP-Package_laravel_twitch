<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Streams;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a group of stream markers belonging to a single user.
 *
 * Returned as a paginated item from getStreamMarkers.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-stream-markers
 */
#[MapInputName(SnakeCaseMapper::class)]
class StreamMarkerGroup extends Data
{
    public function __construct(
        /**
         * @var string User ID of the broadcaster
         */
        public string $userId,

        /**
         * @var string Broadcaster login (lowercase)
         */
        public string $userLogin,

        /**
         * @var string Broadcaster display name
         */
        public string $userName,

        /**
         * @var DataCollection<int, StreamMarkerVideo> Videos with their markers
         */
        #[DataCollectionOf(StreamMarkerVideo::class)]
        public DataCollection $videos,
    ) {}
}
