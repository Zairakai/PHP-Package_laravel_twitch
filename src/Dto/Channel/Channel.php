<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Channel;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents Twitch channel information.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-channel-information
 */
#[MapInputName(SnakeCaseMapper::class)]
class Channel extends Data
{
    public function __construct(
        /**
         * @var string Broadcaster ID
         */
        public string $broadcasterId,

        /**
         * @var string Broadcaster login (lowercase)
         */
        public string $broadcasterLogin,

        /**
         * @var string Broadcaster display name
         */
        public string $broadcasterName,

        /**
         * @var string Broadcaster language (ISO 639-1)
         */
        public string $broadcasterLanguage,

        /**
         * @var string Current game/category ID
         */
        public string $gameId,

        /**
         * @var string Current game/category name
         */
        public string $gameName,

        /**
         * @var string Channel title
         */
        public string $title,

        /**
         * @var int Stream delay in seconds (0 if not set)
         */
        public int $delay,

        /**
         * @var bool Whether the channel is flagged as branded content
         */
        public bool $isBrandedContent,

        /**
         * @var array<string> Tags applied to the channel
         */
        public array $tags = [],

        /**
         * @var array<int, array{id: string, is_enabled: bool}> Content classification labels
         */
        public array $contentClassificationLabels = [],
    ) {}
}
