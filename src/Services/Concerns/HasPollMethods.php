<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Zairakai\LaravelTwitch\Dto\PaginatedResult;
use Zairakai\LaravelTwitch\Dto\Polls\Poll;
use Zairakai\LaravelTwitch\Dto\Polls\Requests\CreatePollRequest;

/**
 * Twitch Polls API methods.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-polls
 */
trait HasPollMethods
{
    /**
     * Create a poll for a broadcaster's channel.
     *
     * Requires: channel:manage:polls
     */
    public function createPoll(CreatePollRequest $createPollRequest): Poll
    {
        /** @var array<string, mixed> $requestData */
        $requestData = array_filter($createPollRequest->toArray(), static fn (mixed $v): bool => null !== $v);

        $raw = $this->makeRequest('POST', '/polls', $requestData);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return Poll::from($items[0]);
    }

    /**
     * End an active poll.
     *
     * Requires: channel:manage:polls
     *
     * @param string $status TERMINATED (end with results) or ARCHIVED (end without showing)
     */
    public function endPoll(string $broadcasterId, string $pollId, string $status = 'TERMINATED'): Poll
    {
        $raw = $this->makeRequest('PATCH', '/polls', [
            'broadcaster_id' => $broadcasterId,
            'id'             => $pollId,
            'status'         => $status,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return Poll::from($items[0]);
    }

    /**
     * Get information about polls for a broadcaster's channel.
     *
     * Requires: channel:read:polls
     *
     * @param string|array<string>|null $pollIds Filter by specific poll ID(s)
     *
     * @return PaginatedResult<Poll>
     */
    public function getPolls(
        string $broadcasterId,
        string|array|null $pollIds = null,
        int $first = 20,
        ?string $after = null,
    ): PaginatedResult {
        $params = [
            'broadcaster_id' => $broadcasterId,
            'first'          => $first,
        ];

        if (null !== $pollIds) {
            $params['id'] = $pollIds;
        }

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/polls', $params);

        return PaginatedResult::fromRaw($raw, Poll::class);
    }
}
