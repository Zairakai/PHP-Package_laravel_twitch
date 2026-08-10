<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `channel.follow` EventSub notification.
 *
 * Requires subscribing at version 2 (requires the `moderator:read:followers`
 * scope) - version 1 of this subscription type is deprecated. Pass
 * `version: '2'` to `Twitch::createEventSubSubscription()`.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelfollow
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelFollowEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $userId,
        public string $userLogin,
        public string $userName,
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public Carbon $followedAt,
    ) {}
}
