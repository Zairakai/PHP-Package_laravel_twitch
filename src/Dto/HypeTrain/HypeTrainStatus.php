<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\HypeTrain;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents the status of a broadcaster's Hype Train, as returned by
 * Get Hype Train Status.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-hype-train-status
 */
#[MapInputName(SnakeCaseMapper::class)]
class HypeTrainStatus extends Data
{
    public function __construct(
        /**
         * @var HypeTrainCurrent|null The currently active Hype Train, null if none is active
         */
        public ?HypeTrainCurrent $current,

        /**
         * @var HypeTrainRecord|null The channel's all-time high Hype Train, null if none has occurred
         */
        public ?HypeTrainRecord $allTimeHigh,

        /**
         * @var HypeTrainRecord|null The channel's shared all-time high Hype Train, null if none has occurred
         */
        public ?HypeTrainRecord $sharedAllTimeHigh,
    ) {}
}
