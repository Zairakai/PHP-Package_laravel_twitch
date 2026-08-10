<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `channel.hype_train.progress` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelhype_trainprogress
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelHypeTrainProgressEvent extends Data implements EventSubEvent
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
        public string $startedAt,
        public string $expiresAt,
        public bool $isSharedTrain,
        public string $type,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sharedTrainParticipants = null,
    ) {}
}
