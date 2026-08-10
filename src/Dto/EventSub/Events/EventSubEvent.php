<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

/**
 * Marker interface for every typed EventSub notification payload.
 *
 * Implemented by both dedicated per-type DTOs (e.g. ChannelFollowEvent) and
 * the GenericEventSubEvent fallback used for subscription types without a
 * dedicated DTO yet.
 *
 * @see EventSubEventFactory
 */
interface EventSubEvent {}
