<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `user.whisper.message` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#userwhispermessage
 */
#[MapInputName(SnakeCaseMapper::class)]
class UserWhisperMessageEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $fromUserId,
        public string $fromUserLogin,
        public string $fromUserName,
        public string $toUserId,
        public string $toUserLogin,
        public string $toUserName,
        public string $whisperId,

        /**
         * @var array<string, mixed>
         */
        public array $whisper,
    ) {}

    public function getBroadcasterUserId(): ?string
    {
        return null;
    }
}
