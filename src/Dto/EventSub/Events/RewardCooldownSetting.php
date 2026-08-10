<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Shape of `global_cooldown` on channel points custom reward events
 * (`{is_enabled, seconds}`) - same intent as RewardLimitSetting but Twitch
 * uses a differently named value field (`seconds` instead of `value`).
 */
#[MapInputName(SnakeCaseMapper::class)]
class RewardCooldownSetting extends Data
{
    public function __construct(
        public bool $isEnabled,
        public int $seconds,
    ) {}
}
