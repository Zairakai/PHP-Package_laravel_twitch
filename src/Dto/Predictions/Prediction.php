<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Predictions;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a Twitch prediction.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-predictions
 */
#[MapInputName(SnakeCaseMapper::class)]
class Prediction extends Data
{
    public function __construct(
        /**
         * @var string Prediction ID
         */
        public string $id,

        /**
         * @var string Broadcaster ID
         */
        public string $broadcasterId,

        /**
         * @var string Broadcaster login (lowercase)
         */
        public string $broadcasterLogin,

        /**
         * @var string Broadcaster display name
         */
        public string $broadcasterName,

        /**
         * @var string Prediction title
         */
        public string $title,

        /**
         * @var string Status: ACTIVE, CANCELED, LOCKED, RESOLVED
         */
        public string $status,

        /**
         * @var int Prediction window in seconds (1-1800)
         */
        public int $predictionWindow,

        /**
         * @var DataCollection<int, Outcome> Possible outcomes
         */
        #[DataCollectionOf(Outcome::class)]
        public DataCollection $outcomes,

        /**
         * @var string|null ID of the winning outcome (when RESOLVED)
         */
        public ?string $winningOutcomeId = null,

        /**
         * @var Carbon|null When the prediction was created
         */
        public ?Carbon $createdAt = null,

        /**
         * @var Carbon|null When the prediction was locked
         */
        public ?Carbon $lockedAt = null,

        /**
         * @var Carbon|null When the prediction ended
         */
        public ?Carbon $endedAt = null,
    ) {}
}
