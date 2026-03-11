<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Zairakai\LaravelTwitch\Dto\Analytics\ExtensionAnalytics;
use Zairakai\LaravelTwitch\Dto\Analytics\GameAnalytics;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;

/**
 * Twitch Analytics API methods.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-extension-analytics
 */
trait HasAnalyticsMethods
{
    /**
     * Get analytics data for one or more extensions.
     *
     * Requires: analytics:read:extensions
     *
     * @param string $type      overview_v2 (default)
     * @param string $startedAt RFC3339 start date (optional, must pair with endedAt)
     * @param string $endedAt   RFC3339 end date (optional, must pair with startedAt)
     *
     * @return PaginatedResult<ExtensionAnalytics>
     */
    public function getExtensionAnalytics(
        ?string $extensionId = null,
        string $type = 'overview_v2',
        ?string $startedAt = null,
        ?string $endedAt = null,
        int $first = 20,
        ?string $after = null,
    ): PaginatedResult {
        $params = [
            'type'  => $type,
            'first' => $first,
        ];

        if (null !== $extensionId) {
            $params['extension_id'] = $extensionId;
        }

        if (null !== $startedAt) {
            $params['started_at'] = $startedAt;
        }

        if (null !== $endedAt) {
            $params['ended_at'] = $endedAt;
        }

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/analytics/extensions', $params);

        return PaginatedResult::fromRaw($raw, ExtensionAnalytics::class);
    }

    /**
     * Get analytics data for one or more games.
     *
     * Requires: analytics:read:games
     *
     * @param string $type      overview_v2 (default)
     * @param string $startedAt RFC3339 start date (optional, must pair with endedAt)
     * @param string $endedAt   RFC3339 end date (optional, must pair with startedAt)
     *
     * @return PaginatedResult<GameAnalytics>
     */
    public function getGameAnalytics(
        ?string $gameId = null,
        string $type = 'overview_v2',
        ?string $startedAt = null,
        ?string $endedAt = null,
        int $first = 20,
        ?string $after = null,
    ): PaginatedResult {
        $params = [
            'type'  => $type,
            'first' => $first,
        ];

        if (null !== $gameId) {
            $params['game_id'] = $gameId;
        }

        if (null !== $startedAt) {
            $params['started_at'] = $startedAt;
        }

        if (null !== $endedAt) {
            $params['ended_at'] = $endedAt;
        }

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/analytics/games', $params);

        return PaginatedResult::fromRaw($raw, GameAnalytics::class);
    }
}
