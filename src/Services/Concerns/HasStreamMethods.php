<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Zairakai\LaravelTwitch\Dto\PaginatedResult;
use Zairakai\LaravelTwitch\Dto\Streams\Clip;
use Zairakai\LaravelTwitch\Dto\Streams\ClipEdit;
use Zairakai\LaravelTwitch\Dto\Streams\Stream;
use Zairakai\LaravelTwitch\Dto\Streams\StreamKey;
use Zairakai\LaravelTwitch\Dto\Streams\StreamMarker;
use Zairakai\LaravelTwitch\Dto\Streams\StreamMarkerGroup;
use Zairakai\LaravelTwitch\Dto\Streams\Video;

/**
 * Twitch Stream, Clip, and Video API methods.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-streams
 */
trait HasStreamMethods
{
    /**
     * Create a clip from a broadcaster's stream.
     *
     * Requires: clips:edit
     */
    public function createClip(string $broadcasterId, bool $hasDelay = false): ClipEdit
    {
        $raw = $this->makeRequest('POST', '/clips', [
            'broadcaster_id' => $broadcasterId,
            'has_delay'      => $hasDelay,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return ClipEdit::from($items[0]);
    }

    /**
     * Create a clip from a VOD (Video on Demand) at a specific timestamp.
     *
     * Requires: clips:edit
     *
     * @param int $vodOffset Offset in seconds from the start of the VOD
     */
    public function createClipFromVod(string $broadcasterId, int $vodOffset): ClipEdit
    {
        $raw = $this->makeRequest('POST', '/clips/vod', [
            'broadcaster_id' => $broadcasterId,
            'vod_offset'     => $vodOffset,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return ClipEdit::from($items[0]);
    }

    /**
     * Add a marker to a live stream at the current timestamp.
     *
     * Requires: channel:manage:broadcast
     */
    public function createStreamMarker(string $userId, ?string $description = null): StreamMarker
    {
        $body = ['user_id' => $userId];

        if (null !== $description) {
            $body['description'] = $description;
        }

        $raw = $this->makeRequest('POST', '/streams/markers', $body);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return StreamMarker::from($items[0]);
    }

    /**
     * Delete one or more videos from a broadcaster's channel.
     *
     * Requires: channel:manage:videos
     *
     * @param string|array<string> $videoIds Video ID(s) to delete
     *
     * @return array<string> IDs of the deleted videos
     */
    public function deleteVideo(string|array $videoIds): array
    {
        $raw = $this->makeRequest('DELETE', '/videos', ['id' => $videoIds]);

        /** @var array<string> $ids */
        $ids = $raw['data'] ?? [];

        return $ids;
    }

    /**
     * Get clips from a broadcaster's channel.
     *
     * Requires: no scope
     *
     * @param string|array<string>|null $clipIds Filter by specific clip ID(s)
     *
     * @return PaginatedResult<Clip>
     */
    public function getClips(
        string $broadcasterId,
        string|array|null $clipIds = null,
        int $first = 20,
        ?string $after = null,
        ?string $startedAt = null,
        ?string $endedAt = null,
    ): PaginatedResult {
        $params = [
            'broadcaster_id' => $broadcasterId,
            'first'          => $first,
        ];

        if (null !== $clipIds) {
            $params['id'] = $clipIds;
        }

        if (null !== $startedAt) {
            $params['started_at'] = $startedAt;
        }

        if (null !== $endedAt) {
            $params['ended_at'] = $endedAt;
        }

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/clips', $params);

        return PaginatedResult::fromRaw($raw, Clip::class);
    }

    /**
     * Get clips by their IDs (includes thumbnail_url for deriving download URLs).
     *
     * Requires: no scope
     *
     * @param string|array<string> $clipIds One or more clip IDs
     *
     * @return PaginatedResult<Clip>
     */
    public function getClipsDownload(string|array $clipIds): PaginatedResult
    {
        $raw = $this->makeRequest('GET', '/clips', [
            'id' => $clipIds,
        ]);

        return PaginatedResult::fromRaw($raw, Clip::class);
    }

    /**
     * Get streams from channels that the authenticated user follows.
     *
     * Requires: user:read:follows
     *
     * @return PaginatedResult<Stream>
     */
    public function getFollowedStreams(string $userId, int $first = 20, ?string $after = null): PaginatedResult
    {
        $params = [
            'user_id' => $userId,
            'first'   => $first,
        ];

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/streams/followed', $params);

        return PaginatedResult::fromRaw($raw, Stream::class);
    }

    /**
     * Get the stream key for the broadcaster's channel.
     *
     * Requires: channel:read:stream_key
     */
    public function getStreamKey(string $broadcasterId): StreamKey
    {
        $raw = $this->makeRequest('GET', '/streams/key', [
            'broadcaster_id' => $broadcasterId,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return StreamKey::from($items[0]);
    }

    /**
     * Get stream markers from a VOD or live stream.
     *
     * Requires: user:read:broadcast
     *
     * @return PaginatedResult<StreamMarkerGroup>
     */
    public function getStreamMarkers(
        string $userId,
        ?string $videoId = null,
        int $first = 20,
        ?string $after = null,
    ): PaginatedResult {
        $params = [
            'user_id' => $userId,
            'first'   => $first,
        ];

        if (null !== $videoId) {
            $params['video_id'] = $videoId;
        }

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/streams/markers', $params);

        return PaginatedResult::fromRaw($raw, StreamMarkerGroup::class);
    }

    /**
     * Get information about active streams.
     *
     * Requires: no scope
     *
     * @param string|array<string>|null $userIds   Filter by user ID(s)
     * @param string|array<string>|null $gameIds   Filter by game ID(s)
     * @param string|array<string>|null $languages Filter by language(s)
     *
     * @return PaginatedResult<Stream>
     */
    public function getStreams(
        string|array|null $userIds = null,
        string|array|null $gameIds = null,
        string|array|null $languages = null,
        int $first = 20,
        ?string $after = null,
    ): PaginatedResult {
        $params = ['first' => $first];

        if (null !== $userIds) {
            $params['user_id'] = $userIds;
        }

        if (null !== $gameIds) {
            $params['game_id'] = $gameIds;
        }

        if (null !== $languages) {
            $params['language'] = $languages;
        }

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/streams', $params);

        return PaginatedResult::fromRaw($raw, Stream::class);
    }

    /**
     * Get videos (past broadcasts, highlights, uploads) for a broadcaster.
     *
     * Requires: no scope
     *
     * @param string|array<string>|null $videoIds Filter by specific video ID(s)
     * @param string                    $type     all, upload, archive, or highlight
     *
     * @return PaginatedResult<Video>
     */
    public function getVideos(
        ?string $userId = null,
        ?string $gameId = null,
        string|array|null $videoIds = null,
        string $type = 'all',
        int $first = 20,
        ?string $after = null,
    ): PaginatedResult {
        $params = [
            'first' => $first,
            'type'  => $type,
        ];

        if (null !== $userId) {
            $params['user_id'] = $userId;
        }

        if (null !== $gameId) {
            $params['game_id'] = $gameId;
        }

        if (null !== $videoIds) {
            $params['id'] = $videoIds;
        }

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/videos', $params);

        return PaginatedResult::fromRaw($raw, Video::class);
    }
}
