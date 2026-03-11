<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Goals;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a creator goal (follower, subscription, new subscription, etc.).
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-creator-goals
 */
#[MapInputName(SnakeCaseMapper::class)]
class Goal extends Data
{
    public function __construct(
        /**
         * @var string Goal ID
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
         * @var string Goal type: follower, subscription, new_subscription, new_subscription_count, new_bit_gifter
         */
        public string $type,

        /**
         * @var string Goal description
         */
        public string $description,

        /**
         * @var int Current progress value
         */
        public int $currentAmount,

        /**
         * @var int Target value
         */
        public int $targetAmount,

        /**
         * @var Carbon|null When the goal was created
         */
        public ?Carbon $createdAt = null,
    ) {}
}
