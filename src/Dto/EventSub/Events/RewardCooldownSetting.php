<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Shape of `global_cooldown` on channel points custom reward events
 * (`{is_enabled, seconds}`) - same intent as RewardLimitSetting but Twitch
 * uses a differently named value field (`seconds` instead of `value`).
 */
#[MapInputName(SnakeCaseMapper::class)]
class RewardCooldownSetting extends TwitchData
{
    public function __construct(
        public bool $isEnabled,
        public int $seconds,
    ) {}
}
