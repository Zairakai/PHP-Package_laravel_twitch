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
     * @param string|null $type   Filter by subscription type
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
     * @return PaginatedResult<Subscription>
     */
    public function getEventSubSubscriptionsByType(string $type): PaginatedResult
    {
        return $this->getEventSubSubscriptions(type: $type, status: 'enabled');
    }
}
