<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Streams;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a broadcaster's stream key.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-stream-key
 */
#[MapInputName(SnakeCaseMapper::class)]
class StreamKey extends Data
{
    public function __construct(
        /**
         * @var string Broadcaster user ID
         */
        public string $broadcasterId,

        /**
         * @var string The broadcaster's stream key
         */
        public string $streamKey,
    ) {}
}
