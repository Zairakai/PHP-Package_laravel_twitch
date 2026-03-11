<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Spatie\LaravelData\DataCollection;
use Zairakai\LaravelTwitch\Dto\Conduits\Conduit;
use Zairakai\LaravelTwitch\Dto\Conduits\ConduitShard;
use Zairakai\LaravelTwitch\Dto\Conduits\Requests\UpdateConduitShardRequest;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;

/**
 * Twitch Conduits API methods.
 *
 * Conduits are a transport for EventSub that enables high-scale, multi-shard deployments.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-conduits
 */
trait HasConduitsMethods
{
    /**
     * Create a new conduit for routing EventSub subscriptions to multiple shards.
     *
     * Requires: app access token
     *
     * @param int $shardCount Number of shards (1-20000)
     */
    public function createConduit(int $shardCount): Conduit
    {
        $raw = $this->makeRequest('POST', '/eventsub/conduits', [
            'shard_count' => $shardCount,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return Conduit::from($items[0]);
    }

    /**
     * Delete a specified conduit.
     *
     * Requires: app access token
     * Note: deleting a conduit also deletes all associated subscriptions.
     */
    public function deleteConduit(string $conduitId): void
    {
        $this->makeRequest('DELETE', '/eventsub/conduits', [
            'id' => $conduitId,
        ]);
    }

    /**
     * Get information about conduits for the app access token.
     *
     * Requires: app access token
     *
     * @return DataCollection<int, Conduit>
     */
    public function getConduits(): DataCollection
    {
        $raw = $this->makeRequest('GET', '/eventsub/conduits', []);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, Conduit> $dataCollection */
        $dataCollection = Conduit::collect($items, DataCollection::class);

        return $dataCollection;
    }

    /**
     * Get the shards associated with a conduit.
     *
     * Requires: app access token
     *
     * @param string $status Filter by shard status (enabled, webhook_callback_verification_pending, etc.)
     *
     * @return PaginatedResult<ConduitShard>
     */
    public function getConduitShards(
        string $conduitId,
        ?string $status = null,
        ?string $after = null,
    ): PaginatedResult {
        $params = ['conduit_id' => $conduitId];

        if (null !== $status) {
            $params['status'] = $status;
        }

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/eventsub/conduits/shards', $params);

        return PaginatedResult::fromRaw($raw, ConduitShard::class);
    }

    /**
     * Update the number of shards for a conduit.
     *
     * Requires: app access token
     *
     * @param int $shardCount New number of shards
     */
    public function updateConduit(string $conduitId, int $shardCount): Conduit
    {
        $raw = $this->makeRequest('PATCH', '/eventsub/conduits', [
            'id'          => $conduitId,
            'shard_count' => $shardCount,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return Conduit::from($items[0]);
    }

    /**
     * Update the transport for shards of a conduit.
     *
     * Requires: app access token
     *
     * @param list<UpdateConduitShardRequest> $shards Shards to update
     *
     * @return DataCollection<int, ConduitShard>
     */
    public function updateConduitShards(string $conduitId, array $shards): DataCollection
    {
        $raw = $this->makeRequest('PATCH', '/eventsub/conduits/shards', [
            'conduit_id' => $conduitId,
            'shards'     => array_map(
                static fn (UpdateConduitShardRequest $updateConduitShardRequest): array => $updateConduitShardRequest->toArray(),
                $shards,
            ),
        ]);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, ConduitShard> $dataCollection */
        $dataCollection = ConduitShard::collect($items, DataCollection::class);

        return $dataCollection;
    }
}
