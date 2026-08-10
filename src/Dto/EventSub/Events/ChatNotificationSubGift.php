<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * `channel.chat.notification` payload when `notice_type` is `sub_gift`.
 *
 * Shape inferred from Twitch's documented EventSub schema, not
 * independently re-verified against a fetched example - double check
 * before relying on it in production.
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChatNotificationSubGift extends Data
{
    public function __construct(
        public int $durationMonths,

        /**
         * @var string Subscription tier: 1000, 2000 or 3000
         */
        public string $subTier,
        public string $recipientUserId,
        public string $recipientUserName,
        public string $recipientUserLogin,

        /**
         * @var int|null Gifter's lifetime total gifted subs - null if not shared
         */
        public ?int $cumulativeTotal = null,

        /**
         * @var string|null Set when this gift is part of a community gift sub batch
         */
        public ?string $communityGiftId = null,
    ) {}
}
