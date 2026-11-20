<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\ContentLabels;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents a Twitch content classification label.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-content-classification-labels
 */
#[MapInputName(SnakeCaseMapper::class)]
class ContentClassificationLabel extends TwitchData
{
    public function __construct(
        /**
         * @var string Label ID (e.g. MatureGame, DrugsIntoxication)
         */
        public string $id,

        /**
         * @var string Label description
         */
        public string $description,

        /**
         * @var string Localized label name
         */
        public string $name,
    ) {}
}
