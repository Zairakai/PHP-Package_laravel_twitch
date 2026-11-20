<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Users;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents the result of checking whether a user subscribes to a channel.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#check-user-subscription
 */
#[MapInputName(SnakeCaseMapper::class)]
class SubscriptionCheck extends TwitchData
{
    public function __construct(
        /**
         * @var string Broadcaster ID
         */
        public string $broadcasterId,

        /**
         * @var string Broadcaster login (lowercase)
         */
        public string $broadcasterLogin,

        /**
         * @var string Broadcaster display name
         */
        public string $broadcasterName,

        /**
         * @var string Subscription tier: 1000, 2000, or 3000
         */
        public string $tier,

        /**
         * @var bool Whether the subscription was gifted
         */
        public bool $isGift,

        /**
         * @var string|null Gifter login (if gifted)
         */
        public ?string $gifterId = null,
        public ?string $gifterLogin = null,

        /**
         * @var string|null Gifter display name (if gifted)
         */
        public ?string $gifterName = null,
    ) {}
}
