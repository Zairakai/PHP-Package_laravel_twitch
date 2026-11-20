<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Conduits;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents an EventSub conduit.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-conduits
 */
#[MapInputName(SnakeCaseMapper::class)]
class Conduit extends TwitchData
{
    public function __construct(
        /**
         * @var string Conduit ID
         */
        public string $id,

        /**
         * @var int Number of shards
         */
        public int $shardCount,
    ) {}
}
