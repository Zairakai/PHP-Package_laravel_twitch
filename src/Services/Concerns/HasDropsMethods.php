<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Spatie\LaravelData\DataCollection;
use Zairakai\LaravelTwitch\Dto\Drops\DropsEntitlement;
use Zairakai\LaravelTwitch\Dto\Drops\EntitlementStatus;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;

/**
 * Twitch Drops Entitlements API methods.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-drops-entitlements
 */
trait HasDropsMethods
{
    /**
     * Get a list of entitlements for a given organization that have been granted to a user.
     *
     * Requires: app access token (for all users of app) or user access token (for the user)
     *
     * @param string|array<string>|null $ids               Filter by entitlement ID(s)
     * @param string                    $fulfillmentStatus Filter by status: CLAIMED, FULFILLED
     *
     * @return PaginatedResult<DropsEntitlement>
     */
    public function getDropsEntitlements(
        string|array|null $ids = null,
        ?string $userId = null,
        ?string $gameId = null,
        ?string $fulfillmentStatus = null,
        int $first = 20,
        ?string $after = null,
    ): PaginatedResult {
        $params = ['first' => $first];

        if (null !== $ids) {
            $params['id'] = $ids;
        }

        if (null !== $userId) {
            $params['user_id'] = $userId;
        }

        if (null !== $gameId) {
            $params['game_id'] = $gameId;
        }

        if (null !== $fulfillmentStatus) {
            $params['fulfillment_status'] = $fulfillmentStatus;
        }

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/entitlements/drops', $params);

        return PaginatedResult::fromRaw($raw, DropsEntitlement::class);
    }

    /**
     * Update the fulfillment status of entitlements.
     *
     * Requires: app access token
     *
     * @param array<string> $entitlementIds    List of entitlement IDs to update (max 100)
     * @param string        $fulfillmentStatus CLAIMED or FULFILLED
     *
     * @return DataCollection<int, EntitlementStatus>
     */
    public function updateDropsEntitlements(array $entitlementIds, string $fulfillmentStatus): DataCollection
    {
        $raw = $this->makeRequest('PATCH', '/entitlements/drops', [
            'entitlement_ids'    => $entitlementIds,
            'fulfillment_status' => $fulfillmentStatus,
        ]);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, EntitlementStatus> $dataCollection */
        $dataCollection = EntitlementStatus::collect($items, DataCollection::class);

        return $dataCollection;
    }
}
