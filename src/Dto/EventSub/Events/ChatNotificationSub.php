<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * `channel.chat.notification` payload when `notice_type` is `sub` (a first-time
 * subscription, as opposed to `resub`).
 *
 * Shape inferred from Twitch's documented EventSub schema, not
 * independently re-verified against a fetched example - double check
 * before relying on it in production.
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChatNotificationSub extends TwitchData
{
    public function __construct(
        /**
         * @var string Subscription tier: 1000, 2000 or 3000
         */
        public string $subTier,
        public bool $isPrime,
        public int $durationMonths,
    ) {}
}
