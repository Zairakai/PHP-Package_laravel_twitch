<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * `channel.chat.notification` payload when `notice_type` is
 * `prime_paid_upgrade` (a Prime sub converted to a paid one).
 *
 * Shape inferred from Twitch's documented EventSub schema, not
 * independently re-verified against a fetched example - double check
 * before relying on it in production.
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChatNotificationPrimePaidUpgrade extends Data
{
    public function __construct(
        /**
         * @var string Subscription tier: 1000, 2000 or 3000
         */
        public string $subTier,
    ) {}
}
