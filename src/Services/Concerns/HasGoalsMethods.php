<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Spatie\LaravelData\DataCollection;
use Zairakai\LaravelTwitch\Dto\Goals\Goal;

/**
 * Twitch Creator Goals API methods.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-creator-goals
 */
trait HasGoalsMethods
{
    /**
     * Get a list of the broadcaster's active goals.
     *
     * Requires: channel:read:goals
     *
     * @return DataCollection<int, Goal>
     */
    public function getCreatorGoals(string $broadcasterId): DataCollection
    {
        $raw = $this->makeRequest('GET', '/goals', [
            'broadcaster_id' => $broadcasterId,
        ]);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, Goal> $dataCollection */
        $dataCollection = Goal::collect($items, DataCollection::class);

        return $dataCollection;
    }
}
