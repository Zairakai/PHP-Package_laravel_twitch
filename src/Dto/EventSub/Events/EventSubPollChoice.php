<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * A single poll choice. Vote counts are absent (and default to null) on
 * `channel.poll.begin` - no votes exist yet - and populated on `.progress`
 * and `.end`.
 *
 * Distinct from `Dto\Polls\PollChoice` (the Helix "Get Polls" API shape).
 */
#[MapInputName(SnakeCaseMapper::class)]
class EventSubPollChoice extends TwitchData
{
    public function __construct(
        public string $id,
        public string $title,
        public ?int $votes = null,
        public ?int $bitsVotes = null,
        public ?int $channelPointsVotes = null,
    ) {}
}
