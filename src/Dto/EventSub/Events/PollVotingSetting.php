<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Shape shared by `bits_voting` and `channel_points_voting` on poll events
 * (`{is_enabled, amount_per_vote}`).
 */
#[MapInputName(SnakeCaseMapper::class)]
class PollVotingSetting extends TwitchData
{
    public function __construct(
        public bool $isEnabled,
        public int $amountPerVote,
    ) {}
}
