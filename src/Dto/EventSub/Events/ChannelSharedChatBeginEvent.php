<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `channel.shared_chat.begin` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelshared_chatbegin
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelSharedChatBeginEvent extends Data implements EventSubEvent
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
}
