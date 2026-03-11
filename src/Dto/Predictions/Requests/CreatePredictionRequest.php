<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Predictions\Requests;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Request DTO for creating a prediction.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#create-prediction
 */
#[MapOutputName(SnakeCaseMapper::class)]
class CreatePredictionRequest extends Data
{
    /**
     * @param list<PredictionOutcomeRequest> $outcomes Possible outcomes (2-10)
     */
    public function __construct(
        /**
         * @var string Broadcaster ID
         */
        public readonly string $broadcasterId,

        /**
         * @var string Prediction title (max 45 characters)
         */
        public readonly string $title,

        /**
         * @var list<PredictionOutcomeRequest> Possible outcomes (2-10, max 25 chars each)
         */
        public readonly array $outcomes,

        /**
         * @var int Voting window in seconds (30-1800)
         */
        public readonly int $predictionWindow,
    ) {}
}
