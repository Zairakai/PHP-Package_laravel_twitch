<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Channel;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a channel returned by the search channels endpoint.
 *
 * Note: this DTO differs from Channel (getChannel) — it includes live status fields.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#search-channels
 */
#[MapInputName(SnakeCaseMapper::class)]
class SearchChannel extends Data
{
    public function __construct(
        /**
         * @var string Broadcaster ID
         */
        public string $id,

        /**
         * @var string Broadcaster display name
         */
        public string $displayName,

        /**
         * @var string Broadcaster login (lowercase)
         */
        public string $broadcasterLogin,

        /**
         * @var string Broadcaster language (ISO 639-1)
         */
        public string $broadcasterLanguage,

        /**
         * @var string Current game ID
         */
        public string $gameId,

        /**
         * @var string Current game name
         */
        public string $gameName,

        /**
         * @var string Channel title
         */
        public string $title,

        /**
         * @var bool Whether the channel is currently live
         */
        public bool $isLive,

        /**
         * @var string Thumbnail URL
         */
        public string $thumbnailUrl,

        /**
         * @var array<string> Tags applied to the channel
         */
        public array $tags = [],

        /**
         * @var Carbon|null When the live stream started (null if offline)
         */
        public ?Carbon $startedAt = null,
    ) {}
}
