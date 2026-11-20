<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Payload of a `channel.unban_request.resolve` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelunban_requestresolve
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelUnbanRequestResolveEvent extends TwitchData implements EventSubEvent
{
    public function __construct(
        public string $id,
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public string $userId,
        public string $userLogin,
        public string $userName,
        public string $status,

        /**
         * @var string|null Moderator who resolved the request (null when it was cancelled)
         */
        public ?string $moderatorUserId = null,
        public ?string $moderatorUserLogin = null,
        public ?string $moderatorUserName = null,
        public ?string $resolutionText = null,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->broadcasterUserId;
    }
}
