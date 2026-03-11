<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Users;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a channel follower.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-channel-followers
 */
#[MapInputName(SnakeCaseMapper::class)]
class Follower extends Data
{
    public function __construct(
        /**
         * @var string Follower user ID
         */
        public string $userId,

        /**
         * @var string Follower login (lowercase)
         */
        public string $userLogin,

        /**
         * @var string Follower display name
         */
        public string $userName,

        /**
         * @var Carbon|null When the user started following
         */
        public ?Carbon $followedAt = null,
    ) {}
}
