<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Users;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a channel that the authenticated user follows.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-followed-channels
 */
#[MapInputName(SnakeCaseMapper::class)]
class FollowedChannel extends Data
{
    public function __construct(
        /**
         * @var string Broadcaster user ID
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
         * @var Carbon|null When the user started following this channel
         */
        public ?Carbon $followedAt = null,
    ) {}
}
