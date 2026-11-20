<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Streams;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents a broadcaster's stream key.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-stream-key
 */
#[MapInputName(SnakeCaseMapper::class)]
class StreamKey extends TwitchData
{
    public function __construct(
        /**
         * @var string Stream key (a secret: never log it)
         */
        public string $streamKey,

        /**
         * @var string|null Broadcaster ID (not sent by Twitch: filled in by getStreamKey())
         */
        public ?string $broadcasterId = null,
    ) {}
}
