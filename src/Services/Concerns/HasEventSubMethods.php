<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use InvalidArgumentException;
use Zairakai\LaravelTwitch\Dto\EventSub\Subscription;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;
use Zairakai\LaravelTwitch\Support\EventSubTypes;

/**
 * Twitch EventSub management methods.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-eventsub-subscriptions
 */
trait HasEventSubMethods
{
    /**
     * Create an EventSub subscription using conduit transport.
     *
     * Requires: app access token
     *
     * @param array<string, string> $condition Subscription-specific condition
     * @param string                $conduitId Conduit that receives the events
     * @param string|null           $version   Version of the type (default: the latest one the package reads)
     */
    public function createEventSubConduitSubscription(
        string $type,
        array $condition,
        string $conduitId,
        ?string $version = null,
    ): Subscription {
        return $this->postEventSubSubscription($type, $condition, [
            'method'     => 'conduit',
            'conduit_id' => $conduitId,
        ], $version);
    }

    /**
     * Create an EventSub subscription using webhook transport.
     *
     * Requires: app access token
     *
     * @param array<string, string> $condition   Subscription-specific condition (e.g. broadcaster_user_id)
     * @param string|null           $callbackUrl Public HTTPS URL to receive events (default: `twitch.eventsub.webhook_callback_url`)
     * @param string|null           $secret      Secret for HMAC verification, 10-100 chars (default: `twitch.eventsub.webhook_secret`)
     * @param string|null           $version     Version of the type. Default: the latest one the package reads (see
     *                                           EventSubTypes), `1` for most types, `2` for channel.follow for example
     */
    public function createEventSubSubscription(
        string $type,
        array $condition,
        ?string $callbackUrl = null,
        ?string $secret = null,
        ?string $version = null,
    ): Subscription {
        $callbackUrl ??= config('twitch.eventsub.webhook_callback_url');
        $secret      ??= config('twitch.eventsub.webhook_secret');

        if (
            ! is_string($callbackUrl)
            || '' === $callbackUrl
            || ! is_string($secret)
            || '' === $secret
        ) {
            throw new InvalidArgumentException(
                'createEventSubSubscription() needs a callback URL and a secret: give them or set '
                . 'twitch.eventsub.webhook_callback_url and twitch.eventsub.webhook_secret.',
            );
        }

        return $this->postEventSubSubscription($type, $condition, [
            'method'   => 'webhook',
            'callback' => $callbackUrl,
            'secret'   => $secret,
        ], $version);
    }

    /**
     * Create an EventSub subscription using WebSocket transport.
     *
     * Requires: user access token
     *
     * @param array<string, string> $condition Subscription-specific condition
     * @param string                $sessionId WebSocket session ID from the welcome message
     * @param string|null           $version   Version of the type (default: the latest one the package reads)
     */
    public function createEventSubWebSocketSubscription(
        string $type,
        array $condition,
        string $sessionId,
        ?string $version = null,
    ): Subscription {
        return $this->postEventSubSubscription($type, $condition, [
            'method'     => 'websocket',
            'session_id' => $sessionId,
        ], $version);
    }

    /**
     * Delete an EventSub subscription.
     *
     * Requires: app access token
     */
    public function deleteEventSubSubscription(string $subscriptionId): void
    {
        $this->makeRequest('DELETE', '/eventsub/subscriptions', [
            'id' => $subscriptionId,
        ]);
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
     * Twitch accepts one filter at a time (400 "cannot specify more than one filter" otherwise, confirmed live):
     * `type`, `status`, `user_id`, `subscription_id` or `conduit_id`. See getEventSubSubscriptionsByType() for the
     * type + status use case.
     *
     * @param string|null $type           Filter by subscription type
     * @param string|null $status         Filter by status (enabled, webhook_callback_verification_pending, etc.)
     * @param string|null $userId         Filter by user ID
     * @param string|null $subscriptionId Filter by subscription ID
     * @param string|null $conduitId      Filter by conduit ID
     *
     * @return PaginatedResult<Subscription>
     *
     * @throws InvalidArgumentException when more than one filter is given
     */
    public function getEventSubSubscriptions(
        ?string $type = null,
        ?string $status = null,
        int $first = 100,
        ?string $after = null,
        ?string $userId = null,
        ?string $subscriptionId = null,
        ?string $conduitId = null,
    ): PaginatedResult {
        $filters = array_filter([
            'type'            => $type,
            'status'          => $status,
            'user_id'         => $userId,
            'subscription_id' => $subscriptionId,
            'conduit_id'      => $conduitId,
        ], static fn (?string $filter): bool => null !== $filter);

        if (count($filters) > 1) {
            throw new InvalidArgumentException(
                'getEventSubSubscriptions() takes one filter at a time (type, status, user, subscription or conduit).',
            );
        }

        $params = [
            'first' => $first,
            ...$filters,
        ];

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest(
            'GET',
            '/eventsub/subscriptions',
            $params,
        );

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

        return new PaginatedResult(
            items: $enabled,
            cursor: $paginatedResult->cursor,
            total: count($enabled),
        );
    }

    /**
     * @param array<string, string> $condition
     * @param array<string, string> $transport
     */
    private function postEventSubSubscription(
        string $type,
        array $condition,
        array $transport,
        ?string $version,
    ): Subscription {
        $body = [
            'type'      => $type,
            'version'   => $version ?? EventSubTypes::defaultVersion($type),
            'condition' => $condition,
            'transport' => $transport,
        ];

        // Twitch refuses a batched type (drop.entitlement.grant) unless batching is asked for explicitly.
        if (EventSubTypes::isBatched($type)) {
            $body['is_batching_enabled'] = true;
        }

        $raw = $this->makeRequest(
            'POST',
            '/eventsub/subscriptions',
            $body,
        );

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return Subscription::from($items[0]);
    }
}
