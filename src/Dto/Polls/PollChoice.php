<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Polls;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents a choice in a Twitch poll.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-polls
 */
#[MapInputName(SnakeCaseMapper::class)]
class PollChoice extends TwitchData
{
    public function __construct(
        /**
         * @var string Choice ID
         */
        public string $id,

        /**
         * @var string Choice text
         */
        public string $title,

        /**
         * @var int Number of regular votes
         */
        public int $votes,

        /**
         * @var int Number of Channel Points votes
         */
        public int $channelPointsVotes,
    ) {}
}
