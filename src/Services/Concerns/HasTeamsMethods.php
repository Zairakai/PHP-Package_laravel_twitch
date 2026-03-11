<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Spatie\LaravelData\DataCollection;
use Zairakai\LaravelTwitch\Dto\Teams\Team;

/**
 * Twitch Teams API methods.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-channel-teams
 */
trait HasTeamsMethods
{
    /**
     * Get the list of Twitch teams that the broadcaster is a member of.
     *
     * Requires: no scope
     *
     * @return DataCollection<int, Team>
     */
    public function getChannelTeams(string $broadcasterId): DataCollection
    {
        $raw = $this->makeRequest('GET', '/teams/channel', [
            'broadcaster_id' => $broadcasterId,
        ]);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, Team> $dataCollection */
        $dataCollection = Team::collect($items, DataCollection::class);

        return $dataCollection;
    }

    /**
     * Get information about one or more Twitch teams.
     *
     * Requires: no scope
     * Note: provide either $name or $id, not both.
     */
    public function getTeams(?string $name = null, ?string $id = null): Team
    {
        $params = [];

        if (null !== $name) {
            $params['name'] = $name;
        }

        if (null !== $id) {
            $params['id'] = $id;
        }

        $raw = $this->makeRequest('GET', '/teams', $params);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return Team::from($items[0]);
    }
}
