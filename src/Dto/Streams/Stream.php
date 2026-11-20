<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Streams;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents an active Twitch stream.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-streams
 */
#[MapInputName(SnakeCaseMapper::class)]
class Stream extends TwitchData
{
    public function __construct(
        /**
         * @var string Stream ID
         */
        public string $id,

        /**
         * @var string Broadcaster user ID
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
         * @var string Game/category ID
         */
        public string $gameId,

        /**
         * @var string Game/category name
         */
        public string $gameName,

        /**
         * @var string Stream type: live or ''
         */
        public string $type,

        /**
         * @var string Stream title
         */
        public string $title,

        /**
         * @var int Current viewer count
         */
        public int $viewerCount,

        /**
         * @var string Stream language (ISO 639-1)
         */
        public string $language,

        /**
         * @var string Thumbnail URL template ({width}x{height})
         */
        public string $thumbnailUrl,

        /**
         * @var bool Whether the stream is flagged as mature
         */
        public bool $isMature,

        /**
         * @var Carbon|null When the stream started (RFC3339)
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $startedAt = null,

        /**
         * @var array<string> Content classification tags
         */
        public array $tags = [],
    ) {}
}
