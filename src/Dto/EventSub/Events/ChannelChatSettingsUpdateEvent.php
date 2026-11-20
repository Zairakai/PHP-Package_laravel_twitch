<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Payload of a `channel.chat_settings.update` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelchat_settingsupdate
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelChatSettingsUpdateEvent extends TwitchData implements EventSubEvent
{
    public function __construct(
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public bool $emoteMode,
        public bool $followerMode,
        public bool $slowMode,
        public bool $subscriberMode,
        public bool $uniqueChatMode,

        /**
         * @var int|null Minutes a viewer must follow before chatting - null when follower mode is off
         */
        public ?int $followerModeDurationMinutes = null,

        /**
         * @var int|null Slow mode wait time in seconds (null when slow mode is off)
         */
        public ?int $slowModeWaitTimeSeconds = null,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->broadcasterUserId;
    }
}
