<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Streams;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a stream marker (created manually on a live stream).
 *
 * Used both as a standalone result from createStreamMarker and as a nested
 * item inside StreamMarkerVideo (returned by getStreamMarkers).
 *
 * @see https://dev.twitch.tv/docs/api/reference/#create-stream-marker
 * @see https://dev.twitch.tv/docs/api/reference/#get-stream-markers
 */
#[MapInputName(SnakeCaseMapper::class)]
class StreamMarker extends Data
{
    public function __construct(
        /**
         * @var string Marker ID
         */
        public string $id,

        /**
         * @var string|null Marker description
         */
        public ?string $description = null,

        /**
         * @var int|null Position in the stream in seconds
         */
        public ?int $positionSeconds = null,

        /**
         * @var bool|null Whether this marker was auto-highlighted by the editor
         */
        public ?bool $isEditorHighlight = null,

        /**
         * @var string|null URL to the marker in the VOD
         */
        public ?string $url = null,

        /**
         * @var string|null Broadcaster ID (only present in createStreamMarker response)
         */
        public ?string $broadcasterId = null,

        /**
         * @var Carbon|null When the marker was created
         */
        public ?Carbon $createdAt = null,
    ) {}
}
