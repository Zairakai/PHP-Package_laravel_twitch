<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Zairakai\LaravelTwitch\Dto\Charity\CharityCampaign;
use Zairakai\LaravelTwitch\Dto\Charity\CharityDonation;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;

/**
 * Twitch Charity Campaign API methods.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-charity-campaign
 */
trait HasCharityMethods
{
    /**
     * Get information about the active charity campaign for a broadcaster's channel.
     *
     * Requires: channel:read:charity
     */
    public function getCharityCampaign(string $broadcasterId): CharityCampaign
    {
        $raw = $this->makeRequest('GET', '/charity/campaigns', [
            'broadcaster_id' => $broadcasterId,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return CharityCampaign::from($items[0]);
    }

    /**
     * Get the list of donations for the active charity campaign for a broadcaster's channel.
     *
     * Requires: channel:read:charity
     *
     * @return PaginatedResult<CharityDonation>
     */
    public function getCharityCampaignDonations(
        string $broadcasterId,
        int $first = 20,
        ?string $after = null,
    ): PaginatedResult {
        $params = [
            'broadcaster_id' => $broadcasterId,
            'first'          => $first,
        ];

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/charity/donations', $params);

        return PaginatedResult::fromRaw($raw, CharityDonation::class);
    }
}
