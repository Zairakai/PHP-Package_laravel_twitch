<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Chat\Structures;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a cheermote fragment within a chat message.
 *
 * A cheermote fragment contains the Bits prefix and amount cheered.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelchatmessage
 */
#[MapInputName(SnakeCaseMapper::class)]
class CheermoteFragment extends Data
{
    public function __construct(
        /**
         * @var string Cheermote prefix (e.g. "Cheer", "PogChamp")
         */
        public string $prefix,

        /**
         * @var int Number of Bits cheered
         */
        public int $bits,

        /**
         * @var int Tier level of the cheermote (1, 100, 500, 1000, 5000, 10000, 100000)
         */
        public int $tier,
    ) {}
}
