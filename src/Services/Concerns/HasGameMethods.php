<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Spatie\LaravelData\DataCollection;
use Zairakai\LaravelTwitch\Dto\Games\Game;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;

/**
 * Twitch Games & Categories API methods.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-games
 */
trait HasGameMethods
{
    /**
     * Get games or categories by ID or name.
     *
     * Requires: no scope
     *
     * @param string|array<string>|null $ids   Game ID(s)
     * @param string|array<string>|null $names Game name(s)
     *
     * @return DataCollection<int, Game>
     */
    public function getGames(
        string|array|null $ids = null,
        string|array|null $names = null,
    ): DataCollection {
        $params = [];

        if (null !== $ids) {
            $params['id'] = $ids;
        }

        if (null !== $names) {
            $params['name'] = $names;
        }

        $raw = $this->makeRequest('GET', '/games', $params);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, Game> $dataCollection */
        $dataCollection = Game::collect($items, DataCollection::class);

        return $dataCollection;
    }

    /**
     * Get the top viewed games on Twitch.
     *
     * Requires: no scope
     *
     * @return PaginatedResult<Game>
     */
    public function getTopGames(int $first = 20, ?string $after = null): PaginatedResult
    {
        $params = ['first' => $first];

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/games/top', $params);

        return PaginatedResult::fromRaw($raw, Game::class);
    }

    /**
     * Search for categories (games).
     *
     * Requires: no scope
     *
     * @return PaginatedResult<Game>
     */
    public function searchCategories(string $query, int $first = 20, ?string $after = null): PaginatedResult
    {
        $params = [
            'query' => $query,
            'first' => $first,
        ];

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/search/categories', $params);

        return PaginatedResult::fromRaw($raw, Game::class);
    }
}
