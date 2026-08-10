<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;

/**
 * Payload of a `channel.hype_train.begin` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelhype_trainbegin
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelHypeTrainBeginEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $id,
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public int $total,
        public int $progress,
        public int $goal,

        /**
         * @var array<int, mixed>
         */
        public array $topContributions,
        public int $level,
        #[WithCast(FlexibleDateTimeCast::class)]
        public Carbon $startedAt,
        #[WithCast(FlexibleDateTimeCast::class)]
        public Carbon $expiresAt,
        public bool $isSharedTrain,
        public string $type,
        public int $allTimeHighLevel,
        public int $allTimeHighTotal,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sharedTrainParticipants = null,
    ) {}
}
