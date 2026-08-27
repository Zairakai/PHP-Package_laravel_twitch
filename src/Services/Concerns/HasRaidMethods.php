<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Zairakai\LaravelTwitch\Dto\HypeTrain\HypeTrainStatus;
use Zairakai\LaravelTwitch\Dto\Raids\Raid;

/**
 * Twitch Raids, Hype Train, and Whispers API methods.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#start-a-raid
 */
trait HasRaidMethods
{
    /**
     * Cancel a pending raid.
     *
     * Requires: channel:manage:raids
     */
    public function cancelRaid(string $broadcasterId): void
    {
        $this->makeRequest('DELETE', '/raids', [
            'broadcaster_id' => $broadcasterId,
        ]);
    }

    /**
     * Get the status of a broadcaster's Hype Train.
     *
     * Requires: channel:read:hype_train
     *
     * Confirmed verbatim against Twitch's own docs (2026-08-27) - GET
     * /helix/hypetrain/status. Real bug fixed here: this used to call Get
     * Hype Train Events at GET /hypetrain/events, an endpoint Twitch has
     * since removed entirely - it would 404 on every call. Get Hype Train
     * Status is the only Hype Train read endpoint that still exists, and
     * has a completely different (nested current/all_time_high/
     * shared_all_time_high) response shape, hence the full DTO rewrite.
     */
    public function getHypeTrainStatus(string $broadcasterId): HypeTrainStatus
    {
        $raw = $this->makeRequest('GET', '/hypetrain/status', [
            'broadcaster_id' => $broadcasterId,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return HypeTrainStatus::from($items[0]);
    }

    /**
     * Send a whisper message to another user.
     *
     * Requires: user:manage:whispers (from the sender, whose account must
     * have a verified phone number)
     *
     * Confirmed verbatim against Twitch's own docs (2026-08-27) - POST
     * /helix/whispers, from_user_id/to_user_id as query params, message as
     * JSON body. Real bug fixed here: all three used to go through
     * makeRequest(), which sends every POST param as JSON body - Twitch
     * would have rejected every call with a 400 ("required query parameter
     * missing"), broken since this method was first written. Twitch
     * silently drops a whisper it suspects violates policy rather than
     * reporting an error (still 204), so a successful call here does not
     * guarantee actual delivery.
     *
     * Rate limits: 40 unique recipients/day, 3/second, 100/minute.
     */
    public function sendWhisper(string $fromUserId, string $toUserId, string $message): void
    {
        $this->makeQueryAndBodyRequest(
            'POST',
            '/whispers',
            ['from_user_id' => $fromUserId, 'to_user_id' => $toUserId],
            ['message'      => $message],
        );
    }

    /**
     * Start a raid from the broadcaster's channel to the target channel.
     *
     * Requires: channel:manage:raids
     */
    public function startRaid(string $fromBroadcasterId, string $toBroadcasterId): Raid
    {
        $raw = $this->makeRequest('POST', '/raids', [
            'from_broadcaster_id' => $fromBroadcasterId,
            'to_broadcaster_id'   => $toBroadcasterId,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return Raid::from($items[0]);
    }
}
