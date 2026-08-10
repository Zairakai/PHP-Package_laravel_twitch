<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `channel.cheer` EventSub notification.
 *
 * Cheerer identity fields are nullable - Twitch nulls them when the user
 * cheered anonymously.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelcheer
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelCheerEvent extends Data implements EventSubEvent
{
    public function __construct(
        public bool $isAnonymous,
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public string $message,
        public int $bits,
        public ?string $userId = null,
        public ?string $userLogin = null,
        public ?string $userName = null,
    ) {}
}
