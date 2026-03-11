<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Zairakai\LaravelTwitch\Dto\Ads\AdSchedule;
use Zairakai\LaravelTwitch\Dto\Ads\AdSnooze;
use Zairakai\LaravelTwitch\Dto\Ads\CommercialResult;

/**
 * Twitch Ads API methods.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#start-commercial
 */
trait HasAdsMethods
{
    /**
     * Get ad schedule information for a broadcaster's channel.
     *
     * Requires: channel:read:ads
     */
    public function getAdSchedule(string $broadcasterId): AdSchedule
    {
        $raw = $this->makeRequest('GET', '/channels/ads', [
            'broadcaster_id' => $broadcasterId,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return AdSchedule::from($items[0]);
    }

    /**
     * Snooze the next scheduled ad for 5 minutes.
     *
     * Requires: channel:manage:ads
     */
    public function snoozeNextAd(string $broadcasterId): AdSnooze
    {
        $raw = $this->makeRequest('POST', '/channels/ads/schedule/snooze', [
            'broadcaster_id' => $broadcasterId,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return AdSnooze::from($items[0]);
    }

    /**
     * Start a commercial on a specified channel.
     *
     * Requires: channel:edit:commercial
     *
     * @param int $length Duration of the commercial in seconds (30, 60, 90, 120, 150, or 180)
     */
    public function startCommercial(string $broadcasterId, int $length): CommercialResult
    {
        $raw = $this->makeRequest('POST', '/channels/commercial', [
            'broadcaster_id' => $broadcasterId,
            'length'         => $length,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return CommercialResult::from($items[0]);
    }
}
