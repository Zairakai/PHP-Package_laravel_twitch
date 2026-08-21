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
 * Payload of a `channel.chat.notification` EventSub notification.
 *
 * This is a discriminated-union event: exactly one of the optional fields
 * below is populated depending on the value of `notice_type` - all others
 * are null, regardless of which one the single reference example happened
 * to show (only `resub` was populated there, confirming that shape).
 *
 * A handful of notice types (`unraid`, `charity_donation`, `modiversary`
 * and their `shared_chat_*` mirrors) are kept as documented arrays rather
 * than dedicated classes - their exact shape isn't confirmed by any fetched
 * example, guessing further nested structure risks being wrong.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelchatnotification
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelChatNotificationEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public string $chatterUserId,
        public string $chatterUserLogin,
        public string $chatterUserName,
        public bool $chatterIsAnonymous,

        /**
         * @var string|null Chat name color - same field as
         *                  ChannelChatMessageEvent::$color, same real-world
         *                  behavior: null when the chatter has no color set,
         *                  not an empty string
         */
        public ?string $color,

        /**
         * @var DataCollection<int, ChatBadge>
         */
        #[DataCollectionOf(ChatBadge::class)]
        public DataCollection $badges,
        public string $systemMessage,
        public string $messageId,
        public Message $message,
        public string $noticeType,
        public ?ChatNotificationSub $sub = null,
        public ?ChatNotificationResub $resub = null,
        public ?ChatNotificationSubGift $subGift = null,
        public ?ChatNotificationCommunitySubGift $communitySubGift = null,
        public ?ChatNotificationGiftPaidUpgrade $giftPaidUpgrade = null,
        public ?ChatNotificationPrimePaidUpgrade $primePaidUpgrade = null,
        public ?ChatNotificationPayItForward $payItForward = null,
        public ?ChatNotificationRaid $raid = null,

        /**
         * @var array<string, mixed>|null Present when notice_type is 'unraid' - likely an empty object
         */
        public ?array $unraid = null,
        public ?ChatNotificationAnnouncement $announcement = null,
        public ?ChatNotificationBitsBadgeTier $bitsBadgeTier = null,

        /**
         * @var array<string, mixed>|null Present when notice_type is 'charity_donation':
         *                                {charity_name, amount: {value, decimal_places, currency}} - shape not
         *                                independently confirmed
         */
        public ?array $charityDonation = null,
        public ?ChatNotificationWatchStreak $watchStreak = null,

        /**
         * @var array<string, mixed>|null Present when notice_type is 'modiversary' - shape
         *                                not independently confirmed
         */
        public ?array $modiversary = null,

        /**
         * Shared-chat mirror of sub.
         */
        public ?ChatNotificationSub $sharedChatSub = null,

        /**
         * Shared-chat mirror of resub.
         */
        public ?ChatNotificationResub $sharedChatResub = null,

        /**
         * Shared-chat mirror of sub_gift.
         */
        public ?ChatNotificationSubGift $sharedChatSubGift = null,

        /**
         * Shared-chat mirror of community_sub_gift.
         */
        public ?ChatNotificationCommunitySubGift $sharedChatCommunitySubGift = null,

        /**
         * Shared-chat mirror of gift_paid_upgrade.
         */
        public ?ChatNotificationGiftPaidUpgrade $sharedChatGiftPaidUpgrade = null,

        /**
         * Shared-chat mirror of prime_paid_upgrade.
         */
        public ?ChatNotificationPrimePaidUpgrade $sharedChatPrimePaidUpgrade = null,

        /**
         * Shared-chat mirror of pay_it_forward.
         */
        public ?ChatNotificationPayItForward $sharedChatPayItForward = null,

        /**
         * Shared-chat mirror of raid.
         */
        public ?ChatNotificationRaid $sharedChatRaid = null,

        /**
         * Shared-chat mirror of announcement.
         */
        public ?ChatNotificationAnnouncement $sharedChatAnnouncement = null,

        /**
         * @var array<string, mixed>|null Shared-chat mirror of modiversary
         */
        public ?array $sharedChatModiversary = null,

        /**
         * @var string|null Shared chat session source broadcaster - see ChannelChatMessageEvent::$sourceBroadcasterUserId
         */
        public ?string $sourceBroadcasterUserId = null,

        /**
         * @var string|null Shared chat session source broadcaster
         */
        public ?string $sourceBroadcasterUserLogin = null,

        /**
         * @var string|null Shared chat session source broadcaster
         */
        public ?string $sourceBroadcasterUserName = null,

        /**
         * @var string|null Shared chat session source message ID
         */
        public ?string $sourceMessageId = null,

        /**
         * @var DataCollection<int, ChatBadge>|null Shared chat session badges
         */
        #[DataCollectionOf(ChatBadge::class)]
        public ?DataCollection $sourceBadges = null,

        /**
         * @var bool|null True if only sent to the source channel during a shared chat session
         */
        public ?bool $isSourceOnly = null,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->broadcasterUserId;
    }
}
