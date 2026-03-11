<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Predictions;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents an outcome option in a Twitch prediction.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-predictions
 */
#[MapInputName(SnakeCaseMapper::class)]
class Outcome extends Data
{
    public function __construct(
        /**
         * @var string Outcome ID
         */
        public string $id,

        /**
         * @var string Outcome title
         */
        public string $title,

        /**
         * @var int Number of Channel Points used on this outcome
         */
        public int $channelPoints,

        /**
         * @var int Number of users who predicted this outcome
         */
        public int $users,

        /**
         * @var string Color: BLUE or PINK
         */
        public string $color,

        /**
         * @var list<array{user_id: string, user_name: string, user_login: string, channel_points_used: int, channel_points_won: int|null}>
         *                                                                                                                                  Top predictors for this outcome
         */
        public array $topPredictors = [],
    ) {}
}
