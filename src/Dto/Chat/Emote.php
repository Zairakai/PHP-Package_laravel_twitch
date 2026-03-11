<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Chat;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a Twitch emote (channel, global, or emote set).
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-channel-emotes
 */
#[MapInputName(SnakeCaseMapper::class)]
class Emote extends Data
{
    public function __construct(
        /**
         * @var string Emote ID
         */
        public string $id,

        /**
         * @var string Emote name/code
         */
        public string $name,

        /**
         * @var array{url_1x: string, url_2x: string, url_4x: string} Static image URLs
         */
        public array $images,

        /**
         * @var array<string> Formats: animated, static
         */
        public array $format,

        /**
         * @var array<string> Scales: 1.0, 2.0, 3.0
         */
        public array $scale,

        /**
         * @var array<string> Theme modes: dark, light
         */
        public array $themeMode,

        /**
         * @var string|null Emote type: bitstier, follower, subscriptions
         */
        public ?string $emoteType = null,

        /**
         * @var string|null Emote set ID
         */
        public ?string $emoteSetId = null,

        /**
         * @var string|null Tier (for sub emotes): 1000, 2000, 3000
         */
        public ?string $tier = null,
    ) {}
}
