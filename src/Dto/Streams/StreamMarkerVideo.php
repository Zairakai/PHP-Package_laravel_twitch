<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Streams;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a video with its associated stream markers.
 *
 * Nested inside StreamMarkerGroup from getStreamMarkers.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-stream-markers
 */
#[MapInputName(SnakeCaseMapper::class)]
class StreamMarkerVideo extends Data
{
    public function __construct(
        /**
         * @var string Video ID
         */
        public string $videoId,

        /**
         * @var DataCollection<int, StreamMarker> Markers on this video
         */
        #[DataCollectionOf(StreamMarker::class)]
        public DataCollection $markers,
    ) {}
}
