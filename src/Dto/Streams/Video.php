<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Streams;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a Twitch video (VOD, highlight, or upload).
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-videos
 */
#[MapInputName(SnakeCaseMapper::class)]
class Video extends Data
{
    public function __construct(
        /**
         * @var string Video ID
         */
        public string $id,

        /**
         * @var string|null Stream ID the video was created from
         */
        public ?string $streamId,

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
         * @var string Video title
         */
        public string $title,

        /**
         * @var string Video description
         */
        public string $description,

        /**
         * @var string Video viewability: public or private
         */
        public string $viewable,

        /**
         * @var int Total view count
         */
        public int $viewCount,

        /**
         * @var string Video language (ISO 639-1)
         */
        public string $language,

        /**
         * @var string Video type: archive, highlight, or upload
         */
        public string $type,

        /**
         * @var string Duration string (e.g. "1h23m45s")
         */
        public string $duration,

        /**
         * @var string Thumbnail URL template ({width}x{height})
         */
        public string $thumbnailUrl,

        /**
         * @var string URL to the video
         */
        public string $url,

        /**
         * @var Carbon|null When the video was created
         */
        public ?Carbon $createdAt = null,

        /**
         * @var Carbon|null When the video was published
         */
        public ?Carbon $publishedAt = null,

        /**
         * @var array<int, array{offset: int, duration: int}> Muted segments
         */
        public array $mutedSegments = [],
    ) {}
}
