<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `channel.guest_star_session.end` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelguest_star_sessionend
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelGuestStarSessionEndEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $broadcasterUserId,
        public string $broadcasterUserName,
        public string $broadcasterUserLogin,
        public string $moderatorUserId,
        public string $moderatorUserName,
        public string $moderatorUserLogin,
        public string $sessionId,
        public string $startedAt,
        public string $endedAt,
    ) {}
}
