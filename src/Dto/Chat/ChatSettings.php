<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Chat;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents the chat settings for a broadcaster's channel.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-chat-settings
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChatSettings extends Data
{
    public function __construct(
        /**
         * @var string Broadcaster ID
         */
        public string $broadcasterId,

        /**
         * @var bool Whether only emotes are allowed in chat
         */
        public bool $emoteMode,

        /**
         * @var bool Whether follower-only mode is enabled
         */
        public bool $followerMode,

        /**
         * @var bool Whether slow mode is enabled
         */
        public bool $slowMode,

        /**
         * @var bool Whether subscriber-only mode is enabled
         */
        public bool $subscriberMode,

        /**
         * @var bool Whether unique chat mode (R9K) is enabled
         */
        public bool $uniqueChatMode,

        /**
         * @var int|null Minutes required to be a follower (0 = any duration)
         */
        public ?int $followerModeDuration = null,

        /**
         * @var int|null Seconds between messages in slow mode
         */
        public ?int $slowModeWaitTime = null,

        /**
         * @var bool|null Whether non-moderator chat is enabled (during shield mode)
         */
        public ?bool $nonModeratorChatDelay = null,

        /**
         * @var int|null Delay in seconds for non-moderator chat
         */
        public ?int $nonModeratorChatDelayDuration = null,
    ) {}
}
