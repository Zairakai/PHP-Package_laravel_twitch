<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `channel.chat.notification` EventSub notification.
 *
 * This is a discriminated-union event: exactly one of the optional fields
 * below is populated depending on the value of the discriminator field -
 * all others are null. Every optional field is nullable regardless of what
 * the single reference example happened to show.
 *
 * Fields generated from the official example payload on 2026-08-09.
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
        public string $color,

        /**
         * @var array<int, mixed>
         */
        public array $badges,
        public string $systemMessage,
        public string $messageId,

        /**
         * @var array<string, mixed>
         */
        public array $message,
        public string $noticeType,

        /**
         * @var array<string, mixed>|null Present when notice_type is 'sub': {sub_tier, is_prime, duration_months}
         */
        public ?array $sub = null,

        /**
         * @var array<string, mixed>|null
         */
        public ?array $resub = null,

        /**
         * @var array<string, mixed>|null Present when notice_type is 'sub_gift'
         */
        public ?array $subGift = null,

        /**
         * @var array<string, mixed>|null Present when notice_type is 'community_sub_gift'
         */
        public ?array $communitySubGift = null,

        /**
         * @var array<string, mixed>|null Present when notice_type is 'gift_paid_upgrade'
         */
        public ?array $giftPaidUpgrade = null,

        /**
         * @var array<string, mixed>|null Present when notice_type is 'prime_paid_upgrade'
         */
        public ?array $primePaidUpgrade = null,

        /**
         * @var array<string, mixed>|null Present when notice_type is 'pay_it_forward'
         */
        public ?array $payItForward = null,

        /**
         * @var array<string, mixed>|null Present when notice_type is 'raid': {user_id, user_login, user_name, viewer_count, profile_image_url}
         */
        public ?array $raid = null,

        /**
         * @var array<string, mixed>|null Present when notice_type is 'unraid'
         */
        public ?array $unraid = null,

        /**
         * @var array<string, mixed>|null Present when notice_type is 'announcement': {color}
         */
        public ?array $announcement = null,

        /**
         * @var array<string, mixed>|null Present when notice_type is 'bits_badge_tier': {tier}
         */
        public ?array $bitsBadgeTier = null,

        /**
         * @var array<string, mixed>|null Present when notice_type is 'charity_donation'
         */
        public ?array $charityDonation = null,

        /**
         * @var array<string, mixed>|null Present when notice_type is 'watch_streak': {watch_streak_months}
         */
        public ?array $watchStreak = null,

        /**
         * @var array<string, mixed>|null Present when notice_type is 'shared_chat_modiversary' or 'modiversary'
         */
        public ?array $modiversary = null,

        /**
         * @var array<string, mixed>|null Shared-chat mirror of sub, present when notice_type is 'shared_chat_sub'
         */
        public ?array $sharedChatSub = null,

        /**
         * @var array<string, mixed>|null Shared-chat mirror of resub
         */
        public ?array $sharedChatResub = null,

        /**
         * @var array<string, mixed>|null Shared-chat mirror of sub_gift
         */
        public ?array $sharedChatSubGift = null,

        /**
         * @var array<string, mixed>|null Shared-chat mirror of community_sub_gift
         */
        public ?array $sharedChatCommunitySubGift = null,

        /**
         * @var array<string, mixed>|null Shared-chat mirror of gift_paid_upgrade
         */
        public ?array $sharedChatGiftPaidUpgrade = null,

        /**
         * @var array<string, mixed>|null Shared-chat mirror of prime_paid_upgrade
         */
        public ?array $sharedChatPrimePaidUpgrade = null,

        /**
         * @var array<string, mixed>|null Shared-chat mirror of pay_it_forward
         */
        public ?array $sharedChatPayItForward = null,

        /**
         * @var array<string, mixed>|null Shared-chat mirror of raid
         */
        public ?array $sharedChatRaid = null,

        /**
         * @var array<string, mixed>|null Shared-chat mirror of announcement
         */
        public ?array $sharedChatAnnouncement = null,

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
         * @var array<int, array{set_id: string, id: string, info: string}>|null Shared chat session badges
         */
        public ?array $sourceBadges = null,

        /**
         * @var bool|null True if only sent to the source channel during a shared chat session
         */
        public ?bool $isSourceOnly = null,
    ) {}
}
