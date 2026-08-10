<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `automod.message.update` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#automodmessageupdate
 */
#[MapInputName(SnakeCaseMapper::class)]
class AutomodMessageUpdateEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $broadcasterUserId,
        public string $broadcasterUserName,
        public string $broadcasterUserLogin,
        public string $userId,
        public string $userName,
        public string $userLogin,
        public string $moderatorUserId,
        public string $moderatorUserLogin,
        public string $moderatorUserName,
        public string $messageId,
        public string $message,
        public int $level,
        public string $category,
        public string $status,
        public string $heldAt,

        /**
         * @var array<string, mixed>
         */
        public array $fragments,
    ) {}
}
