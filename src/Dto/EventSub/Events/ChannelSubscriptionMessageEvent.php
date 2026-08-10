<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `channel.subscription.message` EventSub notification.
 *
 * Sent when a subscriber renews their subscription with a resub message
 * ("sub rebuy" / resub) - distinct from a first-time channel.subscribe.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelsubscriptionmessage
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelSubscriptionMessageEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $userId,
        public string $userLogin,
        public string $userName,
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,

        /**
         * @var string Subscription tier: 1000, 2000 or 3000
         */
        public string $tier,

        /**
         * @var array{text: string, emotes: array<int, array{begin: int, end: int, id: string}>} Resub message
         */
        public array $message,

        /**
         * @var int Cumulative number of months the user has subscribed
         */
        public int $cumulativeMonths,

        /**
         * @var int Number of months subscribed on a consecutive streak
         */
        public int $durationMonths,

        /**
         * @var int|null Current streak in months - null if the user opted out of sharing it
         */
        public ?int $streakMonths = null,
    ) {}
}
