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
         * @var array<int, mixed>
         */
        public array $topContributions,
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
         * @var array<int, array{user_id: string, user_login: string, user_name: string, type: string, total: int}>|null Present when is_shared_train is true
         */
        public ?array $sharedTrainParticipants = null,
    ) {}
}
