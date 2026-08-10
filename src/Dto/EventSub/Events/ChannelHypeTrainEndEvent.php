<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;

/**
 * Payload of a `channel.hype_train.end` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelhype_trainend
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelHypeTrainEndEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $id,
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public int $total,

        /**
         * @var DataCollection<int, HypeTrainContribution>
         */
        #[DataCollectionOf(HypeTrainContribution::class)]
        public DataCollection $topContributions,
        public int $level,
        #[WithCast(FlexibleDateTimeCast::class)]
        public Carbon $startedAt,
        #[WithCast(FlexibleDateTimeCast::class)]
        public Carbon $endedAt,
        #[WithCast(FlexibleDateTimeCast::class)]
        public Carbon $cooldownEndsAt,
        public bool $isSharedTrain,
        public string $type,

        /**
         * @var DataCollection<int, HypeTrainContribution>|null Present when is_shared_train is true
         */
        #[DataCollectionOf(HypeTrainContribution::class)]
        public ?DataCollection $sharedTrainParticipants = null,
    ) {}
}
