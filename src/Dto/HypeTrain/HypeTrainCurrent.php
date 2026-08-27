<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\HypeTrain;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents the currently active Hype Train, as returned nested inside
 * Get Hype Train Status.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-hype-train-status
 */
#[MapInputName(SnakeCaseMapper::class)]
class HypeTrainCurrent extends Data
{
    public function __construct(
        /**
         * @var string Hype Train ID
         */
        public string $id,

        /**
         * @var string Broadcaster ID
         */
        public string $broadcasterUserId,

        /**
         * @var string Broadcaster login name
         */
        public string $broadcasterUserLogin,

        /**
         * @var string Broadcaster display name
         */
        public string $broadcasterUserName,

        /**
         * @var int Current level of the Hype Train
         */
        public int $level,

        /**
         * @var int Total points contributed to the Hype Train
         */
        public int $total,

        /**
         * @var int Points contributed at the current level
         */
        public int $progress,

        /**
         * @var int Points required to reach the next level
         */
        public int $goal,

        /**
         * @var DataCollection<int, HypeTrainContributor> Contributors with the most points
         */
        #[DataCollectionOf(HypeTrainContributor::class)]
        public DataCollection $topContributions,

        /**
         * @var Carbon When the Hype Train started
         */
        public Carbon $startedAt,

        /**
         * @var Carbon When the Hype Train expires (extended each time it levels up)
         */
        public Carbon $expiresAt,

        /**
         * @var string Hype Train type: treasure, golden_kappa, or regular
         */
        public string $type,

        /**
         * @var bool Whether this Hype Train is shared with other broadcasters
         */
        public bool $isSharedTrain,

        /**
         * @var DataCollection<int, HypeTrainParticipant>|null Broadcasters participating in a shared Hype Train, null if not shared
         */
        #[DataCollectionOf(HypeTrainParticipant::class)]
        public ?DataCollection $sharedTrainParticipants = null,
    ) {}
}
