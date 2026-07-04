<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Deprecated;

/**
 * Twitch Tags API methods.
 *
 * @deprecated These endpoints are deprecated by Twitch as of February 2023.
 *             Twitch no longer supports user-defined tags via the API.
 * @see https://dev.twitch.tv/docs/api/reference/#get-all-stream-tags
 */
trait HasTagsMethods
{
    /**
     * Get all stream tags defined by Twitch.
     *
     * @param string|null $tagId A specific tag ID to look up
     *
     * @return array<string, mixed>
     */
    #[Deprecated(message: <<<'TXT'
    Deprecated by Twitch. No replacement provided.
     
     Requires: no scope
    TXT)]
    public function getAllStreamTags(?string $tagId = null, int $first = 20, ?string $after = null): array
    {
        $params = ['first' => $first];

        if (null !== $tagId) {
            $params['tag_id'] = $tagId;
        }

        if (null !== $after) {
            $params['after'] = $after;
        }

        return $this->makeRequest('GET', '/tags/streams', $params);
    }

    /**
     * Get the list of stream tags that are set on the specified channel.
     *
     * @return array<string, mixed>
     */
    #[Deprecated(message: <<<'TXT'
    Deprecated by Twitch. No replacement provided.
     
     Requires: no scope
    TXT)]
    public function getStreamTags(string $broadcasterId): array
    {
        return $this->makeRequest('GET', '/streams/tags', [
            'broadcaster_id' => $broadcasterId,
        ]);
    }
}
