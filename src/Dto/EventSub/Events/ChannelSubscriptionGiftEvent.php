<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `channel.subscription.gift` EventSub notification.
 *
 * Gifter identity fields are nullable - Twitch nulls them when the gifter
 * chose to gift anonymously (mirrors the is_anonymous pattern also seen on
 * channel.cheer).
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelsubscriptiongift
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelSubscriptionGiftEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,

        /**
         * @var int Number of subscriptions gifted in this event
         */
        public int $total,

        /**
         * @var string Subscription tier: 1000, 2000 or 3000
         */
        public string $tier,
        public bool $isAnonymous,
        public ?string $userId = null,
        public ?string $userLogin = null,
        public ?string $userName = null,

        /**
         * @var int|null Gifter's lifetime total gifted subs on this channel - null if
         *               anonymous or the gifter opted out of sharing this count
         */
        public ?int $cumulativeTotal = null,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->broadcasterUserId;
    }
}
