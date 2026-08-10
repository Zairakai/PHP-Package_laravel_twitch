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
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sub = null,

        /**
         * @var array<string, mixed>|null
         */
        public ?array $resub = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $subGift = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $communitySubGift = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $giftPaidUpgrade = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $primePaidUpgrade = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $payItForward = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $raid = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $unraid = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $announcement = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $bitsBadgeTier = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $charityDonation = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $watchStreak = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $modiversary = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sharedChatSub = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sharedChatResub = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sharedChatSubGift = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sharedChatCommunitySubGift = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sharedChatGiftPaidUpgrade = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sharedChatPrimePaidUpgrade = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sharedChatPayItForward = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sharedChatRaid = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sharedChatAnnouncement = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sharedChatModiversary = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sourceBroadcasterUserId = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sourceBroadcasterUserLogin = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sourceBroadcasterUserName = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sourceMessageId = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sourceBadges = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $isSourceOnly = null,
    ) {}
}
