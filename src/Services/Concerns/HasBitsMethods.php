<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Spatie\LaravelData\DataCollection;
use Zairakai\LaravelTwitch\Dto\Bits\BitsLeaderboardEntry;
use Zairakai\LaravelTwitch\Dto\Bits\Cheermote;
use Zairakai\LaravelTwitch\Dto\Bits\ExtensionTransaction;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;

/**
 * Twitch Bits API methods.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-bits-leaderboard
 */
trait HasBitsMethods
{
    /**
     * Get the top bits leaderboard for a broadcaster's channel.
     *
     * Requires: bits:read
     *
     * @param int    $count  Number of results to return (1-100)
     * @param string $period DAY, WEEK, MONTH, YEAR, or ALL
     *
     * @return DataCollection<int, BitsLeaderboardEntry>
     */
    public function getBitsLeaderboard(
        int $count = 10,
        string $period = 'ALL',
        ?string $userId = null,
        ?string $startedAt = null,
    ): DataCollection {
        $params = [
            'count'  => $count,
            'period' => $period,
        ];

        if (null !== $userId) {
            $params['user_id'] = $userId;
        }

        if (null !== $startedAt) {
            $params['started_at'] = $startedAt;
        }

        $raw = $this->makeRequest('GET', '/bits/leaderboard', $params);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, BitsLeaderboardEntry> $dataCollection */
        $dataCollection = BitsLeaderboardEntry::collect($items, DataCollection::class);

        return $dataCollection;
    }

    /**
     * Get the list of Cheermotes for a broadcaster's channel.
     *
     * Requires: no scope
     *
     * @return DataCollection<int, Cheermote>
     */
    public function getCheermotes(?string $broadcasterId = null): DataCollection
    {
        $params = [];

        if (null !== $broadcasterId) {
            $params['broadcaster_id'] = $broadcasterId;
        }

        $raw = $this->makeRequest('GET', '/bits/cheermotes', $params);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, Cheermote> $dataCollection */
        $dataCollection = Cheermote::collect($items, DataCollection::class);

        return $dataCollection;
    }

    /**
     * Get a list of transactions for an extension.
     *
     * Requires: app access token
     *
     * @param string|array<string>|null $transactionIds Filter by specific transaction ID(s)
     *
     * @return PaginatedResult<ExtensionTransaction>
     */
    public function getExtensionTransactions(
        string $extensionId,
        string|array|null $transactionIds = null,
        ?string $after = null,
        int $first = 20,
    ): PaginatedResult {
        $params = [
            'extension_id' => $extensionId,
            'first'        => $first,
        ];

        if (null !== $transactionIds) {
            $params['id'] = $transactionIds;
        }

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/extensions/transactions', $params);

        return PaginatedResult::fromRaw($raw, ExtensionTransaction::class);
    }
}
