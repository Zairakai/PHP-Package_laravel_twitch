<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Shape shared by `bits_voting` and `channel_points_voting` on poll events
 * (`{is_enabled, amount_per_vote}`).
 */
#[MapInputName(SnakeCaseMapper::class)]
class PollVotingSetting extends Data
{
    public function __construct(
        public bool $isEnabled,
        public int $amountPerVote,
    ) {}
}
