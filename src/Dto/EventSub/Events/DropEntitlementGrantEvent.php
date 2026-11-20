<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\Drops\DropEntitlementGrant;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Payload of a `drop.entitlement.grant` EventSub notification.
 *
 * Unlike the other types, Twitch delivers it in batches: the notification carries `events` (a list), not `event`,
 * and the subscription must be created with `is_batching_enabled`. It belongs to an organization, not to a
 * broadcaster, so there is no broadcaster ID.
 *
 * @see https://dev.twitch.tv/docs/eventsub/reference/drop
 */
#[MapInputName(SnakeCaseMapper::class)]
class DropEntitlementGrantEvent extends TwitchData implements EventSubEvent
{
    public function __construct(
        /**
         * @var DataCollection<int, DropEntitlementGrant>
         */
        #[DataCollectionOf(DropEntitlementGrant::class)]
        public DataCollection $events,
    ) {}

    public function getBroadcasterUserId(): ?string
    {
        return null;
    }
}
