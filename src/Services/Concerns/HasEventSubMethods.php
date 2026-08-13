<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Zairakai\LaravelTwitch\Dto\EventSub\Subscription;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;

/**
 * Twitch EventSub management methods.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-eventsub-subscriptions
 */
trait HasEventSubMethods
{
    /**
     * Create an EventSub subscription using webhook transport.
     *
     * Requires: app access token
     *
     * @param array<string, string> $condition   Subscription-specific condition (e.g. broadcaster_user_id)
     * @param string                $callbackUrl Public HTTPS URL to receive events
     * @param string                $secret      Secret for HMAC verification (10-100 chars)
     * @param string                $version     Subscription type version (default '1')
     */
    public function createEventSubSubscription(
        string $type,
        array $condition,
        string $callbackUrl,
        string $secret,
        string $version = '1',
    ): Subscription {
        $raw = $this->makeRequest('POST', '/eventsub/subscriptions', [
            'type'      => $type,
            'version'   => $version,
            'condition' => $condition,
            'transport' => [
                'method'   => 'webhook',
                'callback' => $callbackUrl,
                'secret'   => $secret,
            ],
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return Subscription::from($items[0]);
    }

    /**
     * Create an EventSub subscription using WebSocket transport.
     *
     * Requires: user access token
     *
     * @param array<string, string> $condition Subscription-specific condition
     * @param string                $sessionId WebSocket session ID from the welcome message
     * @param string                $version   Subscription type version (default '1')
     */
    public function createEventSubWebSocketSubscription(
        string $type,
        array $condition,
        string $sessionId,
        string $version = '1',
    ): Subscription {
        $raw = $this->makeRequest('POST', '/eventsub/subscriptions', [
            'type'      => $type,
            'version'   => $version,
            'condition' => $condition,
            'transport' => [
                'method'     => 'websocket',
                'session_id' => $sessionId,
            ],
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return Subscription::from($items[0]);
    }

    /**
     * Delete an EventSub subscription.
     *
     * Requires: app access token
     */
    public function deleteEventSubSubscription(string $subscriptionId): void
    {
        $this->makeRequest('DELETE', '/eventsub/subscriptions', ['id' => $subscriptionId]);
    }

    /**
     * Delete all EventSub subscriptions that match a given type.
     *
     * @return int Number of deleted subscriptions
     */
    public function deleteEventSubSubscriptionsByType(string $type): int
    {
        $result  = $this->getEventSubSubscriptions(type: $type);
        $deleted = 0;

        foreach ($result->items as $subscription) {
            $this->deleteEventSubSubscription($subscription->id);
            $deleted++;
        }

        return $deleted;
    }

    /**
     * Get a list of EventSub subscriptions.
     *
     * Requires: app access token
     *
     * @param string|null $type   Filter by subscription type. Mutually exclusive with $status -
     *                            Twitch's API rejects a request specifying both with a 400
     *                            "cannot specify more than one filter" (confirmed live against
     *                            the real API, not documented explicitly). Passing both here
     *                            is the caller's responsibility to avoid; see
     *                            getEventSubSubscriptionsByType() for the type+status use case.
     * @param string|null $status Filter by status (enabled, webhook_callback_verification_pending, etc.)
     *
     * @return PaginatedResult<Subscription>
     */
    public function getEventSubSubscriptions(
        ?string $type = null,
        ?string $status = null,
        int $first = 100,
        ?string $after = null,
    ): PaginatedResult {
        $params = ['first' => $first];

        if (null !== $type) {
            $params['type'] = $type;
        }

        if (null !== $status) {
            $params['status'] = $status;
        }

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/eventsub/subscriptions', $params);

        return PaginatedResult::fromRaw($raw, Subscription::class);
    }

    /**
     * Get all active EventSub subscriptions of a given type.
     *
     * Filters by type only against the API and narrows to status=enabled
     * client-side, rather than passing both filters to Twitch - the real
     * API rejects `type` and `status` together with a 400 "cannot specify
     * more than one filter" (confirmed live, not called out in the written
     * docs). A single page (100 items) is fetched - a broadcaster with more
     * than 100 subscriptions of the very same type is not a case this
     * package needs to paginate through today.
     *
     * @return PaginatedResult<Subscription>
     */
    public function getEventSubSubscriptionsByType(string $type): PaginatedResult
    {
        $paginatedResult = $this->getEventSubSubscriptions(type: $type);

        $enabled = array_values(array_filter(
            $paginatedResult->items,
            static fn (Subscription $subscription): bool => 'enabled' === $subscription->status,
        ));

        return new PaginatedResult(items: $enabled, cursor: $paginatedResult->cursor, total: count($enabled));
    }
}
