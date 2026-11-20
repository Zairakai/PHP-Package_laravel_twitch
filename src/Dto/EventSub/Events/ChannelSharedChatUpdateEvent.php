<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Payload of a `channel.shared_chat.update` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelshared_chatupdate
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelSharedChatUpdateEvent extends TwitchData implements EventSubEvent
{
    public function __construct(
        public string $sessionId,
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public string $hostBroadcasterUserId,
        public string $hostBroadcasterUserLogin,
        public string $hostBroadcasterUserName,

        /**
         * @var array<int, mixed>
         */
        public array $participants,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->broadcasterUserId;
    }
}
