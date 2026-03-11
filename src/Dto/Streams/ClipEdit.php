<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Streams;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents the result of creating a clip (edit URL + clip ID).
 *
 * @see https://dev.twitch.tv/docs/api/reference/#create-clip
 */
#[MapInputName(SnakeCaseMapper::class)]
class ClipEdit extends Data
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
