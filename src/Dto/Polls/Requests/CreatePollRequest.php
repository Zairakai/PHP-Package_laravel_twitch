<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Polls\Requests;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Request DTO for creating a poll.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#create-poll
 */
#[MapOutputName(SnakeCaseMapper::class)]
class CreatePollRequest extends Data
{
    /**
     * @param list<PollChoiceRequest> $choices Poll choices (2-5 choices, max 25 chars each)
     */
    public function __construct(
        /**
         * @var string Broadcaster ID
         */
        public readonly string $broadcasterId,

        /**
         * @var string Poll title (max 60 characters)
         */
        public readonly string $title,

        /**
         * @var list<PollChoiceRequest> Poll choices (2-5 choices)
         */
        public readonly array $choices,

        /**
         * @var int Duration in seconds (15-1800)
         */
        public readonly int $duration,

        /**
         * @var bool|null Whether viewers can vote with Channel Points
         */
        public readonly ?bool $channelPointsVotingEnabled = null,

        /**
         * @var int|null Channel Points per vote (1-1,000,000)
         */
        public readonly ?int $channelPointsPerVote = null,
    ) {}
}
