<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\HypeTrain;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a Hype Train event.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-hype-train-events
 */
#[MapInputName(SnakeCaseMapper::class)]
class HypeTrain extends Data
{
    public function __construct(
        /**
         * @var string Hype Train event ID
         */
        public string $id,

        /**
         * @var string Event type: hypetrain.progression
         */
        public string $eventType,

        /**
         * @var string Broadcaster ID
         */
        public string $broadcasterId,

        /**
         * @var int Current Hype Train level (1-5)
         */
        public int $level,

        /**
         * @var int Total points contributed
         */
        public int $total,

        /**
         * @var int Points towards next level
         */
        public int $progress,

        /**
         * @var int Points required for next level
         */
        public int $goal,

        /**
         * @var list<array{type: string, user: string, total: int}> Top contributors
         */
        public array $topContributions,

        /**
         * @var array{type: string, user: string, total: int}|null Last contribution
         */
        public ?array $lastContribution,

        /**
         * @var Carbon|null When the Hype Train started
         */
        public ?Carbon $startedAt = null,

        /**
         * @var Carbon|null When the Hype Train expires
         */
        public ?Carbon $expiresAt = null,

        /**
         * @var Carbon|null When the cooldown ends
         */
        public ?Carbon $cooldownEndTime = null,

        /**
         * @var Carbon|null When this event occurred
         */
        public ?Carbon $eventTimestamp = null,
    ) {}
}
