<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * `channel.chat.notification` payload when `notice_type` is `resub` (or
 * `shared_chat_resub`) - verified against the official example payload.
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChatNotificationResub extends Data
{
    public function __construct(
        public int $cumulativeMonths,
        public int $durationMonths,

        /**
         * @var string Subscription tier: 1000, 2000 or 3000
         */
        public string $subPlan,
        public bool $isGift,

        /**
         * @var int|null Current streak in months - null if not shared
         */
        public ?int $streakMonths = null,
        public ?bool $gifterIsAnonymous = null,
        public ?string $gifterUserId = null,
        public ?string $gifterUserName = null,
        public ?string $gifterUserLogin = null,
    ) {}
}
