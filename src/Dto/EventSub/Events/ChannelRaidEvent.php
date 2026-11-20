<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Payload of a `channel.raid` EventSub notification.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelraid
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelRaidEvent extends TwitchData implements EventSubEvent
{
    public function __construct(
        public string $fromBroadcasterUserId,
        public string $fromBroadcasterUserLogin,
        public string $fromBroadcasterUserName,
        public string $toBroadcasterUserId,
        public string $toBroadcasterUserLogin,
        public string $toBroadcasterUserName,
        public int $viewers,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->toBroadcasterUserId;
    }
}
