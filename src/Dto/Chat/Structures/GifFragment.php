<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Chat\Structures;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * A GIF in a chat message (fragment of type `gif`, added by Twitch on 2026-07-16).
 *
 * @see https://dev.twitch.tv/docs/eventsub/reference/chat
 */
#[MapInputName(SnakeCaseMapper::class)]
class GifFragment extends TwitchData
{
    public function __construct(
        /**
         * @var string GIF ID
         */
        public string $id,

        /**
         * @var string URL of the GIF
         */
        public string $url,
    ) {}
}
