<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Payload of a `channel.warning.send` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelwarningsend
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelWarningSendEvent extends TwitchData implements EventSubEvent
{
    public function __construct(
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public string $moderatorUserId,
        public string $moderatorUserLogin,
        public string $moderatorUserName,
        public string $userId,
        public string $userLogin,
        public string $userName,

        /**
         * @var array<int, string>|null Chat rule text cited by the moderator, if any
         */
        /**
         * @var string|null Reason of the warning
         */
        public ?string $reason = null,
        public ?array $chatRulesCited = null,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->broadcasterUserId;
    }
}
