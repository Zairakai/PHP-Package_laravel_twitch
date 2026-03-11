<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Bits;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a Cheermote with its available tiers.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-cheermotes
 */
#[MapInputName(SnakeCaseMapper::class)]
class Cheermote extends Data
{
    public function __construct(
        /**
         * @var string Cheermote prefix used in chat (e.g. "Cheer", "BibleThump")
         */
        public string $prefix,

        /**
         * @var DataCollection<int, CheermoteTier> Available tiers for this cheermote
         */
        #[DataCollectionOf(CheermoteTier::class)]
        public DataCollection $tiers,

        /**
         * @var string Cheermote type (global_first_party, global_third_party, channel_custom, etc.)
         */
        public string $type,

        /**
         * @var int Display order in the Bits card
         */
        public int $order,

        /**
         * @var string ISO 8601 datetime when the cheermote was last updated
         */
        public string $lastUpdated,

        /**
         * @var bool Whether this cheermote supports a charity campaign
         */
        public bool $isCharitable,
    ) {}
}
