<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Games;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a Twitch game / category.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-games
 */
#[MapInputName(SnakeCaseMapper::class)]
class Game extends Data
{
    public function __construct(
        /**
         * @var string Game ID
         */
        public string $id,

        /**
         * @var string Game name
         */
        public string $name,

        /**
         * @var string Box art URL template ({width}x{height})
         */
        public string $boxArtUrl,

        /**
         * @var string|null IGDB (Internet Game Database) ID
         */
        public ?string $igdbId = null,
    ) {}
}
