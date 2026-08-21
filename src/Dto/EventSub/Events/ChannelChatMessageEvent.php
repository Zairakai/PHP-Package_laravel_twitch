<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\Chat\Structures\Message;

/**
 * Payload of a `channel.chat.message` EventSub notification.
 *
 * Field set verified against the official example payloads (regular and shared
 * chat) on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelchatmessage
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelChatMessageEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public string $chatterUserId,
        public string $chatterUserLogin,
        public string $chatterUserName,
        public string $messageId,
        public Message $message,

        /**
         * @var string|null Chat name color - Twitch's own docs example shows an empty
         *                  string when not set, but real production payloads send null
         *                  (confirmed 2026-08-21 against live traffic, was typed
         *                  non-nullable string, crashing on every chatter without a
         *                  set color)
         */
        public ?string $color,

        /**
         * @var DataCollection<int, ChatBadge> Badges displayed with this message
         */
        #[DataCollectionOf(ChatBadge::class)]
        public DataCollection $badges,

        /**
         * @var string text, channel_points_highlighted, channel_points_sub_only,
         *             user_intro, power_ups_message_effect or power_ups_gigantified_emote
         */
        public string $messageType,
        public ?ChatMessageCheer $cheer = null,
        public ?ChatMessageReply $reply = null,
        public ?string $channelPointsCustomRewardId = null,

        // ── Shared chat session fields - present only when the message was sent
        // in a shared chat session from a source channel other than this one ──

        public ?string $sourceBroadcasterUserId = null,
        public ?string $sourceBroadcasterUserLogin = null,
        public ?string $sourceBroadcasterUserName = null,
        public ?string $sourceMessageId = null,

        /**
         * @var DataCollection<int, ChatBadge>|null
         */
        #[DataCollectionOf(ChatBadge::class)]
        public ?DataCollection $sourceBadges = null,
        public ?bool $isSourceOnly = null,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->broadcasterUserId;
    }
}
