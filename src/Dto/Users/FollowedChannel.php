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
 * Represents a channel that the authenticated user follows.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-followed-channels
 */
#[MapInputName(SnakeCaseMapper::class)]
class FollowedChannel extends TwitchData
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
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $followedAt = null,
    ) {}
}
