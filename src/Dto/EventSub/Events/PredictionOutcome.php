<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * A single prediction outcome. `users`/`channelPoints`/`topPredictors` are
 * absent (and default to null) on `channel.prediction.begin` - no bets have
 * been placed yet - and populated on `.progress`, `.lock` and `.end`.
 *
 * Distinct from `Dto\Predictions\Outcome` (the Helix "Get Predictions" API
 * shape).
 */
#[MapInputName(SnakeCaseMapper::class)]
class PredictionOutcome extends Data
{
    public function __construct(
        public string $id,
        public string $title,
        public string $color,
        public ?int $users = null,
        public ?int $channelPoints = null,

        /**
         * @var DataCollection<int, PredictionTopPredictor>|null Up to 10 top predictors
         */
        #[DataCollectionOf(PredictionTopPredictor::class)]
        public ?DataCollection $topPredictors = null,
    ) {}
}
