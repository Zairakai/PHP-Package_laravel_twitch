<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * `channel.chat.notification` payload when `notice_type` is
 * `community_sub_gift` (a batch of gift subs to the community).
 *
 * Shape inferred from Twitch's documented EventSub schema, not
 * independently re-verified against a fetched example - double check
 * before relying on it in production.
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChatNotificationCommunitySubGift extends Data
{
    public function __construct(
        public string $id,
        public int $total,

        /**
         * @var string Subscription tier: 1000, 2000 or 3000
         */
        public string $subTier,

        /**
         * @var int|null Gifter's lifetime total gifted subs - null if not shared
         */
        public ?int $cumulativeTotal = null,
    ) {}
}
