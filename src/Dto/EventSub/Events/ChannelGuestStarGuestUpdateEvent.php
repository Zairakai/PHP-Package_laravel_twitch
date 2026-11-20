<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Payload of a `channel.guest_star_guest.update` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelguest_star_guestupdate
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelGuestStarGuestUpdateEvent extends TwitchData implements EventSubEvent
{
    public function __construct(
        public string $broadcasterUserId,
        public string $broadcasterUserName,
        public string $broadcasterUserLogin,
        public string $sessionId,
        /**
         * @var string|null The host: listed by the reference, absent from its example
         */
        public ?string $hostUserId = null,
        public ?string $hostUserName = null,
        public ?string $hostUserLogin = null,
        public ?string $moderatorUserId = null,
        public ?string $moderatorUserName = null,
        public ?string $moderatorUserLogin = null,
        public ?string $guestUserId = null,
        public ?string $guestUserName = null,
        public ?string $guestUserLogin = null,

        /**
         * @var string|null Slot of the guest (null while invited, or removed)
         */
        public ?string $slotId = null,

        /**
         * @var string|null invited, accepted, ready, backstage or live
         */
        public ?string $state = null,
        public ?bool $hostVideoEnabled = null,
        public ?bool $hostAudioEnabled = null,
        public ?int $hostVolume = null,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->broadcasterUserId;
    }
}
