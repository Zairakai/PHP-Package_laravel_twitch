<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Zairakai\LaravelTwitch\Dto\HypeTrain\HypeTrain;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;
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
     * Get information about the broadcaster's Hype Train events.
     *
     * Requires: channel:read:hype_train
     *
     * @return PaginatedResult<HypeTrain>
     */
    public function getHypeTrainEvents(
        string $broadcasterId,
        int $first = 1,
        ?string $after = null,
    ): PaginatedResult {
        $params = [
            'broadcaster_id' => $broadcasterId,
            'first'          => $first,
        ];

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/hypetrain/events', $params);

        return PaginatedResult::fromRaw($raw, HypeTrain::class);
    }

    /**
     * Send a whisper message to another user.
     *
     * Requires: user:manage:whispers
     * Note: The bot must have verified bot status or be a moderator to bypass rate limits.
     */
    public function sendWhisper(string $fromUserId, string $toUserId, string $message): void
    {
        $this->makeRequest('POST', '/whispers', [
            'from_user_id' => $fromUserId,
            'to_user_id'   => $toUserId,
            'message'      => $message,
        ]);
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
