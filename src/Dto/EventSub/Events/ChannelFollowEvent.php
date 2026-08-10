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
