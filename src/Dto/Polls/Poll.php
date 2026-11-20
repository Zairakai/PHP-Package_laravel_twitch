<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Polls;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents a Twitch poll.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-polls
 */
#[MapInputName(SnakeCaseMapper::class)]
class Poll extends TwitchData
{
    public function __construct(
        /**
         * @var string Poll ID
         */
        public string $id,

        /**
         * @var string Broadcaster ID
         */
        public string $broadcasterId,

        /**
         * @var string Broadcaster login (lowercase)
         */
        public string $broadcasterLogin,

        /**
         * @var string Broadcaster display name
         */
        public string $broadcasterName,

        /**
         * @var string Poll title
         */
        public string $title,

        /**
         * @var string Poll status: ACTIVE, COMPLETED, TERMINATED, ARCHIVED, MODERATED, INVALID
         */
        public string $status,

        /**
         * @var int Duration in seconds (15-1800)
         */
        public int $duration,

        /**
         * @var bool Whether Channel Points voting is enabled
         */
        public bool $channelPointsVotingEnabled,

        /**
         * @var int Channel Points cost per vote
         */
        public int $channelPointsPerVote,

        /**
         * @var DataCollection<int, PollChoice> Poll choices
         */
        #[DataCollectionOf(PollChoice::class)]
        public DataCollection $choices,

        /**
         * @var Carbon|null When the poll started
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $startedAt = null,

        /**
         * @var Carbon|null When the poll ended
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $endedAt = null,
    ) {}
}
