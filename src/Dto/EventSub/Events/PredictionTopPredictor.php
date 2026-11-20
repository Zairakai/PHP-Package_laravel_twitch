<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * One of up to 10 top predictors listed inside a PredictionOutcome.
 */
#[MapInputName(SnakeCaseMapper::class)]
class PredictionTopPredictor extends TwitchData
{
    public function __construct(
        public string $userName,
        public string $userLogin,
        public string $userId,
        public int $channelPointsUsed,

        /**
         * @var int|null Points won - null until the prediction resolves
         */
        public ?int $channelPointsWon = null,
    ) {}
}
