<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Streams;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents the result of creating a clip (edit URL + clip ID).
 *
 * @see https://dev.twitch.tv/docs/api/reference/#create-clip
 */
#[MapInputName(SnakeCaseMapper::class)]
class ClipEdit extends TwitchData
{
    public function __construct(
        /**
         * @var string ID of the clip that was created
         */
        public string $id,

        /**
         * @var string URL for the clip edit page
         */
        public string $editUrl,
    ) {}
}
