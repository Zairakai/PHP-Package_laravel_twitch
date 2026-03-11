<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Streams;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a Twitch clip.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-clips
 */
#[MapInputName(SnakeCaseMapper::class)]
class Clip extends Data
{
    public function __construct(
        /**
         * @var string Clip ID
         */
        public string $id,

        /**
         * @var string URL to view the clip
         */
        public string $url,

        /**
         * @var string Embed URL for the clip
         */
        public string $embedUrl,

        /**
         * @var string ID of the broadcaster
         */
        public string $broadcasterId,

        /**
         * @var string Display name of the broadcaster
         */
        public string $broadcasterName,

        /**
         * @var string ID of the user who created the clip
         */
        public string $creatorId,

        /**
         * @var string Display name of the clip creator
         */
        public string $creatorName,

        /**
         * @var string ID of the video the clip was taken from
         */
        public string $videoId,

        /**
         * @var string ID of the game being played
         */
        public string $gameId,

        /**
         * @var string Language of the clip (ISO 639-1)
         */
        public string $language,

        /**
         * @var string Title of the clip
         */
        public string $title,

        /**
         * @var int Number of views
         */
        public int $viewCount,

        /**
         * @var float Duration of the clip in seconds
         */
        public float $duration,

        /**
         * @var int|null Offset in the VOD where the clip starts
         */
        public ?int $vodOffset,

        /**
         * @var Carbon|null When the clip was created
         */
        public ?Carbon $createdAt = null,

        /**
         * @var string Thumbnail URL
         */
        public string $thumbnailUrl = '',

        /**
         * @var bool Whether the clip is featured
         */
        public bool $isFeatured = false,
    ) {}
}
