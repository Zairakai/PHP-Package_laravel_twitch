<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Bits;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a single entry in the Bits leaderboard.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-bits-leaderboard
 */
#[MapInputName(SnakeCaseMapper::class)]
class BitsLeaderboardEntry extends Data
{
    public function __construct(
        /**
         * @var string User ID
         */
        public string $userId,

        /**
         * @var string User login (lowercase)
         */
        public string $userLogin,

        /**
         * @var string User display name
         */
        public string $userName,

        /**
         * @var int Total Bits cheered
         */
        public int $score,

        /**
         * @var int Rank on the leaderboard
         */
        public int $rank,
    ) {}
}
