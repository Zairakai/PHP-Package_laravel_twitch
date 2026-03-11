<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Analytics;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents an analytics report URL for a game.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-game-analytics
 */
#[MapInputName(SnakeCaseMapper::class)]
class GameAnalytics extends Data
{
    public function __construct(
        /**
         * @var string Game ID
         */
        public string $gameId,

        /**
         * @var string URL to download the analytics report (CSV)
         */
        public string $url,

        /**
         * @var string Report type (e.g. overview_v2)
         */
        public string $type,

        /**
         * @var array<string, string> Report date range (started_at, ended_at as RFC3339 strings)
         */
        public array $dateRange = [],
    ) {}
}
