<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

/**
 * Interface for every typed EventSub notification payload.
 *
 * Implemented by both dedicated per-type DTOs (e.g. ChannelFollowEvent) and
 * the GenericEventSubEvent fallback used for subscription types without a
 * dedicated DTO yet.
 *
 * @see EventSubEventFactory
 */
interface EventSubEvent
{
    /**
     * The Twitch user ID of the channel this event belongs to, or null when
     * the event has no single channel owner (user-scoped or app-scoped
     * events such as UserUpdateEvent, or a raw GenericEventSubEvent fallback
     * whose payload has no broadcaster_user_id field).
     *
     * For ChannelRaidEvent, returns the target channel (to_broadcaster_user_id)
     * - the channel whose automations should react to the raid, not the source.
     */
    public function getBroadcasterUserId(): ?string;
}
