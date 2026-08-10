<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * A single poll choice. Vote counts are absent (and default to null) on
 * `channel.poll.begin` - no votes exist yet - and populated on `.progress`
 * and `.end`.
 *
 * Distinct from `Dto\Polls\PollChoice` (the Helix "Get Polls" API shape).
 */
#[MapInputName(SnakeCaseMapper::class)]
class EventSubPollChoice extends Data
{
    public function __construct(
        public string $id,
        public string $title,
        public ?int $votes = null,
        public ?int $bitsVotes = null,
        public ?int $channelPointsVotes = null,
    ) {}
}
