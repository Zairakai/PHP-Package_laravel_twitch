<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Conduits;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents an EventSub conduit.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-conduits
 */
#[MapInputName(SnakeCaseMapper::class)]
class Conduit extends Data
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
