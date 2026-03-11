<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Chat\Requests;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Request DTO for updating chat settings.
 *
 * All fields are optional — only provided fields will be updated.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#update-chat-settings
 */
#[MapOutputName(SnakeCaseMapper::class)]
class UpdateChatSettingsRequest extends Data
{
    public function __construct(
        /**
         * @var bool|null Whether only emotes are allowed in chat
         */
        public readonly ?bool $emoteMode = null,

        /**
         * @var bool|null Whether follower-only mode is enabled
         */
        public readonly ?bool $followerMode = null,

        /**
         * @var int|null Minutes required to be a follower (0-129600)
         */
        public readonly ?int $followerModeDuration = null,

        /**
         * @var bool|null Whether non-moderator chat delay is enabled
         */
        public readonly ?bool $nonModeratorChatDelay = null,

        /**
         * @var int|null Non-moderator chat delay in seconds (2, 4, or 6)
         */
        public readonly ?int $nonModeratorChatDelayDuration = null,

        /**
         * @var bool|null Whether slow mode is enabled
         */
        public readonly ?bool $slowMode = null,

        /**
         * @var int|null Seconds between messages in slow mode (3-120)
         */
        public readonly ?int $slowModeWaitTime = null,

        /**
         * @var bool|null Whether subscriber-only mode is enabled
         */
        public readonly ?bool $subscriberMode = null,

        /**
         * @var bool|null Whether unique chat mode (R9K) is enabled
         */
        public readonly ?bool $uniqueChatMode = null,
    ) {}
}
