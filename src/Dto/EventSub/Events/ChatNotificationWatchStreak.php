<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * `channel.chat.notification` payload when `notice_type` is `watch_streak`.
 *
 * Corrected against a real notification captured during Monsieur's
 * 2026-08-27 stream - the original fields (`watch_streak_months`) were
 * inferred from documentation and never independently verified; the real
 * wire payload carries `streak_count`/`channel_points_awarded` instead,
 * which crashed every watch-streak notification (`ArgumentCountError`,
 * 0 args passed) until fixed.
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChatNotificationWatchStreak extends Data
{
    public function __construct(
        /**
         * @var int Number of consecutive streams watched
         */
        public int $streakCount,

        /**
         * @var int Channel points awarded for the streak
         */
        public int $channelPointsAwarded,
    ) {}
}
