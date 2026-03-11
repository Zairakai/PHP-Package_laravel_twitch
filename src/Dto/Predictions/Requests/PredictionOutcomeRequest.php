<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Predictions\Requests;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a prediction outcome for CreatePredictionRequest.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#create-prediction
 */
#[MapOutputName(SnakeCaseMapper::class)]
class PredictionOutcomeRequest extends Data
{
    public function __construct(
        /**
         * @var string Outcome title (max 25 characters)
         */
        public readonly string $title,
    ) {}
}
