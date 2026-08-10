<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `channel.chat_settings.update` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelchat_settingsupdate
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelChatSettingsUpdateEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public bool $emoteMode,
        public bool $followerMode,
        public bool $slowMode,
        public int $slowModeWaitTimeSeconds,
        public bool $subscriberMode,
        public bool $uniqueChatMode,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $followerModeDurationMinutes = null,
    ) {}
}
