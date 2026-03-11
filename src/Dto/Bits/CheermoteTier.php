<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Bits;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a single tier within a Cheermote.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-cheermotes
 */
#[MapInputName(SnakeCaseMapper::class)]
class CheermoteTier extends Data
{
    public function __construct(
        /**
         * @var int Minimum Bits required to use this tier
         */
        public int $minBits,

        /**
         * @var string Tier identifier (e.g. "1", "100", "1000")
         */
        public string $id,

        /**
         * @var string Hex color for this tier (e.g. "#979797")
         */
        public string $color,

        /**
         * @var array<string, mixed> Image URLs (dark/light × animated/static × sizes)
         */
        public array $images,

        /**
         * @var bool Whether the authenticated user can use this tier
         */
        public bool $canCheer,

        /**
         * @var bool Whether this tier appears in the Bits card
         */
        public bool $showInBitsCard,
    ) {}
}
