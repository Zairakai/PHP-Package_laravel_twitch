<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Data;

/**
 * Fallback payload for any EventSub subscription type without a dedicated DTO yet.
 *
 * Guarantees every notification is still captured and typed at the object
 * level even before a specific event DTO exists - nothing is silently
 * dropped, only left less structured until it earns its own DTO.
 *
 * @see EventSubEventFactory
 */
class GenericEventSubEvent extends Data implements EventSubEvent
{
    public function __construct(
        /**
         * @var string Subscription type as sent by Twitch (e.g. channel.cheer, channel.poll.begin)
         */
        public string $type,

        /**
         * @var array<string, mixed> Raw, untyped event payload as received from Twitch
         */
        public array $payload,
    ) {}
}
