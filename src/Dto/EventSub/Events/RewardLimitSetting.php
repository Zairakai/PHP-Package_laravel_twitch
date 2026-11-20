<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Shape shared by `max_per_stream` and `max_per_user_per_stream` on channel
 * points custom reward events (`{is_enabled, value}`).
 */
#[MapInputName(SnakeCaseMapper::class)]
class RewardLimitSetting extends TwitchData
{
    public function __construct(
        public bool $isEnabled,
        public int $value,
    ) {}
}
