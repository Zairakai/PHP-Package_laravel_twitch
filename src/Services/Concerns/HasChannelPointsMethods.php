<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Spatie\LaravelData\DataCollection;
use Zairakai\LaravelTwitch\Dto\ChannelPoints\CustomReward;
use Zairakai\LaravelTwitch\Dto\ChannelPoints\Redemption;
use Zairakai\LaravelTwitch\Dto\ChannelPoints\Requests\CreateCustomRewardRequest;
use Zairakai\LaravelTwitch\Dto\ChannelPoints\Requests\UpdateCustomRewardRequest;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;

/**
 * Twitch Channel Points API methods.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-custom-reward
 */
trait HasChannelPointsMethods
{
    /**
     * Create a new custom reward for a broadcaster's channel.
     *
     * Requires: channel:manage:redemptions
     */
    public function createCustomReward(
        string $broadcasterId,
        CreateCustomRewardRequest $createCustomRewardRequest,
    ): CustomReward {
        /** @var array<string, mixed> $requestData */
        $requestData = array_filter($createCustomRewardRequest->toArray(), static fn (mixed $v): bool => null !== $v);

        $raw = $this->makeRequest('POST', '/channel_points/custom_rewards', array_merge([
            'broadcaster_id' => $broadcasterId,
        ], $requestData));

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return CustomReward::from($items[0]);
    }

    /**
     * Delete a custom reward for a broadcaster's channel.
     *
     * Requires: channel:manage:redemptions
     */
    public function deleteCustomReward(string $broadcasterId, string $rewardId): void
    {
        $this->makeRequest('DELETE', '/channel_points/custom_rewards', [
            'broadcaster_id' => $broadcasterId,
            'id'             => $rewardId,
        ]);
    }

    /**
     * Get the list of custom rewards for a broadcaster's channel.
     *
     * Requires: channel:read:redemptions or channel:manage:redemptions
     *
     * @param string|array<string>|null $rewardIds Filter by reward ID(s)
     *
     * @return DataCollection<int, CustomReward>
     */
    public function getCustomRewards(
        string $broadcasterId,
        string|array|null $rewardIds = null,
        bool $onlyManageable = false,
    ): DataCollection {
        $params = [
            'broadcaster_id'          => $broadcasterId,
            'only_manageable_rewards' => $onlyManageable,
        ];

        if (null !== $rewardIds) {
            $params['id'] = $rewardIds;
        }

        $raw = $this->makeRequest('GET', '/channel_points/custom_rewards', $params);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, CustomReward> $dataCollection */
        $dataCollection = CustomReward::collect($items, DataCollection::class);

        return $dataCollection;
    }

    /**
     * Get a list of redemptions for a custom reward.
     *
     * Requires: channel:read:redemptions or channel:manage:redemptions
     *
     * @param string|null               $status        UNFULFILLED, FULFILLED, or CANCELED
     * @param string|array<string>|null $redemptionIds Filter by specific redemption ID(s)
     *
     * @return PaginatedResult<Redemption>
     */
    public function getRedemptions(
        string $broadcasterId,
        string $rewardId,
        ?string $status = null,
        string|array|null $redemptionIds = null,
        int $first = 20,
        ?string $after = null,
    ): PaginatedResult {
        $params = [
            'broadcaster_id' => $broadcasterId,
            'reward_id'      => $rewardId,
            'first'          => $first,
        ];

        if (null !== $status) {
            $params['status'] = $status;
        }

        if (null !== $redemptionIds) {
            $params['id'] = $redemptionIds;
        }

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/channel_points/custom_rewards/redemptions', $params);

        return PaginatedResult::fromRaw($raw, Redemption::class);
    }

    /**
     * Update a custom reward for a broadcaster's channel.
     *
     * Requires: channel:manage:redemptions
     */
    public function updateCustomReward(
        string $broadcasterId,
        string $rewardId,
        UpdateCustomRewardRequest $updateCustomRewardRequest,
    ): CustomReward {
        /** @var array<string, mixed> $requestData */
        $requestData = array_filter($updateCustomRewardRequest->toArray(), static fn (mixed $v): bool => null !== $v);

        $raw = $this->makeRequest('PATCH', '/channel_points/custom_rewards', array_merge([
            'broadcaster_id' => $broadcasterId,
            'id'             => $rewardId,
        ], $requestData));

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return CustomReward::from($items[0]);
    }

    /**
     * Update the redemption status for one or more redemptions.
     *
     * Requires: channel:manage:redemptions
     * Note: Can only update redemptions in UNFULFILLED status.
     *
     * @param string|array<string> $redemptionIds Redemption ID(s) to update
     * @param string               $status        FULFILLED or CANCELED
     *
     * @return DataCollection<int, Redemption>
     */
    public function updateRedemptionStatus(
        string $broadcasterId,
        string $rewardId,
        string|array $redemptionIds,
        string $status,
    ): DataCollection {
        $raw = $this->makeRequest('PATCH', '/channel_points/custom_rewards/redemptions', [
            'broadcaster_id' => $broadcasterId,
            'reward_id'      => $rewardId,
            'id'             => $redemptionIds,
            'status'         => $status,
        ]);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, Redemption> $dataCollection */
        $dataCollection = Redemption::collect($items, DataCollection::class);

        return $dataCollection;
    }
}
