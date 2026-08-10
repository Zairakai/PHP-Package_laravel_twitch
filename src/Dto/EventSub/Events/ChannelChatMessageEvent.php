<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\Chat\Structures\Message;

/**
 * Payload of a `channel.chat.message` EventSub notification.
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
         * @var string text, channel_points_highlighted, channel_points_sub_only,
         *             user_intro, power_ups_message_effect or power_ups_gigantified_emote
         */
        public string $messageType,

        /**
         * @var array<int, array{set_id: string, id: string, info: string}> Badges displayed with this message
         */
        public array $badges,

        /**
         * @var string|null Chat name color, empty string if not set
         */
        public ?string $color = null,

        /**
         * @var array{bits: int}|null Present when the message included a cheer
         */
        public ?array $cheer = null,

        /**
         * @var array<string, mixed>|null Present when this message is a reply to another message
         */
        public ?array $reply = null,
        public ?string $channelPointsCustomRewardId = null,
        public ?string $channelPointsAnimationId = null,
    ) {}
}
