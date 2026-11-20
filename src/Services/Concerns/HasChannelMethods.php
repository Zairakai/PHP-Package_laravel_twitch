<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Spatie\LaravelData\DataCollection;
use UnexpectedValueException;
use Zairakai\LaravelTwitch\Dto\Channel\Channel;
use Zairakai\LaravelTwitch\Dto\Channel\ChannelEditor;
use Zairakai\LaravelTwitch\Dto\Channel\Requests\CreateScheduleSegmentRequest;
use Zairakai\LaravelTwitch\Dto\Channel\Requests\UpdateChannelRequest;
use Zairakai\LaravelTwitch\Dto\Channel\Requests\UpdateScheduleSegmentRequest;
use Zairakai\LaravelTwitch\Dto\Channel\Requests\UpdateScheduleSettingsRequest;
use Zairakai\LaravelTwitch\Dto\Channel\Schedule;
use Zairakai\LaravelTwitch\Dto\Channel\ScheduleSegment;
use Zairakai\LaravelTwitch\Dto\Channel\SearchChannel;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;
use Zairakai\LaravelTwitch\Exceptions\TwitchApiException;

/**
 * Twitch Channel API methods.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-channel-information
 */
trait HasChannelMethods
{
    /**
     * Add a single or recurring broadcast segment to the broadcaster's streaming schedule.
     *
     * Requires: channel:manage:schedule
     */
    public function createScheduleSegment(
        string $broadcasterId,
        CreateScheduleSegmentRequest $createScheduleSegmentRequest,
    ): ScheduleSegment {
        /** @var array<string, mixed> $requestData */
        $requestData = array_filter(
            $createScheduleSegmentRequest->toArray(),
            static fn (mixed $v): bool => null !== $v,
        );

        $raw = $this->makeRequest('POST', '/schedule/segment', array_merge(
            [
                'broadcaster_id' => $broadcasterId,
            ],
            $requestData,
        ));

        return ScheduleSegment::from($this->firstScheduleSegment($raw));
    }

    /**
     * Remove a segment from the broadcaster's streaming schedule.
     *
     * Requires: channel:manage:schedule
     */
    public function deleteScheduleSegment(string $broadcasterId, string $segmentId): void
    {
        $this->makeRequest('DELETE', '/schedule/segment', [
            'broadcaster_id' => $broadcasterId,
            'id'             => $segmentId,
        ]);
    }

    /**
     * Get information about one or more channels.
     *
     * Requires: no scope
     *
     * @param string|array<string> $broadcasterIds One or more broadcaster IDs (max 100)
     *
     * @return DataCollection<int, Channel>
     */
    public function getChannel(string|array $broadcasterIds): DataCollection
    {
        $raw = $this->makeCachedRequest('channel', '/channels', [
            'broadcaster_id' => $broadcasterIds,
        ]);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, Channel> $dataCollection */
        $dataCollection = Channel::collect($items, DataCollection::class);

        return $dataCollection;
    }

    /**
     * Get a list of users who are editors for a channel.
     *
     * Requires: channel:read:editors
     *
     * @return DataCollection<int, ChannelEditor>
     */
    public function getChannelEditors(string $broadcasterId): DataCollection
    {
        $raw = $this->makeRequest('GET', '/channels/editors', [
            'broadcaster_id' => $broadcasterId,
        ]);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, ChannelEditor> $dataCollection */
        $dataCollection = ChannelEditor::collect($items, DataCollection::class);

        return $dataCollection;
    }

    /**
     * Get the broadcaster's stream schedule. A broadcaster who has planned nothing gives an empty schedule.
     *
     * Requires: no scope
     *
     * Note: unlike most list endpoints, the API returns data as a single object
     * (not an array) with nested segments. Pagination cursor applies to the
     * segments collection, not to the top-level data.
     */
    public function getSchedule(
        string $broadcasterId,
        ?string $segmentId = null,
        int $first = 20,
        ?string $after = null,
        ?string $startTime = null,
    ): Schedule {
        $params = array_filter([
            'broadcaster_id' => $broadcasterId,
            'first'          => $first,
            'id'             => $segmentId,
            'after'          => $after,
            'start_time'     => $startTime,
        ], static fn (string|int|null $value): bool => null !== $value);

        try {
            $raw = $this->makeRequest(
                'GET',
                '/schedule',
                $params,
            );
        }
        catch (TwitchApiException $twitchApiException) {
            // 404: the broadcaster has planned nothing (or the segment asked for does not exist). That is no error.
            if (404 === $twitchApiException->status()) {
                return Schedule::none($broadcasterId);
            }

            throw $twitchApiException;
        }

        /** @var array<string, mixed> $data */
        $data = $raw['data'];

        return Schedule::from($data);
    }

    /**
     * Get the broadcaster's stream schedule as an iCalendar file.
     *
     * Requires: no scope
     *
     * Note: Twitch returns a raw text/calendar (iCal) string for this endpoint.
     * The raw iCal content is returned as-is; parse it with an iCal library as needed.
     */
    public function getScheduleCalendar(string $broadcasterId): string
    {
        return $this->makeRawRequest('GET', '/schedule/icalendar', [
            'broadcaster_id' => $broadcasterId,
        ]);
    }

    /**
     * Search for Twitch channels by query string.
     *
     * Requires: no scope
     *
     * @return PaginatedResult<SearchChannel>
     */
    public function searchChannels(
        string $query,
        int $first = 20,
        ?string $after = null,
        bool $liveOnly = false,
    ): PaginatedResult {
        $params = [
            'query'     => $query,
            'first'     => $first,
            'live_only' => $liveOnly,
        ];

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest(
            'GET',
            '/search/channels',
            $params,
        );

        return PaginatedResult::fromRaw($raw, SearchChannel::class);
    }

    /**
     * Update a channel's properties.
     *
     * Requires: channel:manage:broadcast
     */
    public function updateChannel(string $broadcasterId, UpdateChannelRequest $updateChannelRequest): void
    {
        /** @var array<string, mixed> $requestData */
        $requestData = array_filter($updateChannelRequest->toArray(), static fn (mixed $v): bool => null !== $v);

        $this->makeRequest('PATCH', '/channels', array_merge(
            [
                'broadcaster_id' => $broadcasterId,
            ],
            $requestData,
        ));
    }

    /**
     * Update a segment in the broadcaster's streaming schedule.
     *
     * Requires: channel:manage:schedule
     */
    public function updateScheduleSegment(
        string $broadcasterId,
        string $segmentId,
        UpdateScheduleSegmentRequest $updateScheduleSegmentRequest,
    ): ScheduleSegment {
        /** @var array<string, mixed> $requestData */
        $requestData = array_filter(
            $updateScheduleSegmentRequest->toArray(),
            static fn (mixed $v): bool => null !== $v,
        );

        $raw = $this->makeRequest('PATCH', '/schedule/segment', array_merge(
            [
                'broadcaster_id' => $broadcasterId,
                'id'             => $segmentId,
            ],
            $requestData,
        ));

        return ScheduleSegment::from($this->firstScheduleSegment($raw));
    }

    /**
     * Update the broadcaster's stream schedule settings (e.g. vacation mode).
     *
     * Requires: channel:manage:schedule
     */
    public function updateScheduleSettings(
        string $broadcasterId,
        UpdateScheduleSettingsRequest $updateScheduleSettingsRequest,
    ): void {
        /** @var array<string, mixed> $requestData */
        $requestData = array_filter(
            $updateScheduleSettingsRequest->toArray(),
            static fn (mixed $v): bool => null !== $v,
        );

        $this->makeRequest('PATCH', '/schedule/settings', array_merge(
            [
                'broadcaster_id' => $broadcasterId,
            ],
            $requestData,
        ));
    }

    /**
     * The schedule endpoints answer `data: {segments: [...], broadcaster_id, ...}` (an object), not a list: the
     * segment that was created or updated is the first of `segments`.
     *
     * @param array<string, mixed> $raw
     *
     * @return array<string, mixed>
     */
    private function firstScheduleSegment(array $raw): array
    {
        $data     = is_array($raw['data'] ?? null)
            ? $raw['data']
            : [];
        $segments = is_array($data['segments'] ?? null)
            ? $data['segments']
            : [];
        $segment  = $segments[0] ?? null;

        if (! is_array($segment)) {
            throw new UnexpectedValueException('Twitch answered without the schedule segment.');
        }

        /** @var array<string, mixed> $segment */
        return $segment;
    }
}
