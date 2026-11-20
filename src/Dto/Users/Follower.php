<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Users;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents a channel follower.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-channel-followers
 */
#[MapInputName(SnakeCaseMapper::class)]
class Follower extends TwitchData
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
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $followedAt = null,
    ) {}
}
