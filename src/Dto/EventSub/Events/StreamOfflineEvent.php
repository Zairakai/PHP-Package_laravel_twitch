<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Payload of a `stream.offline` EventSub notification.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#streamoffline
 */
#[MapInputName(SnakeCaseMapper::class)]
class StreamOfflineEvent extends TwitchData implements EventSubEvent
{
    public function __construct(
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,

        /**
         * @var string|null Stream ID (added by Twitch on 2026-06-26, absent from older payloads)
         */
        public ?string $id = null,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->broadcasterUserId;
    }
}
