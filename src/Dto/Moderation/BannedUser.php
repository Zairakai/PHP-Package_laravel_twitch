<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Moderation;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents a banned or timed-out user in a broadcaster's channel.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-banned-users
 */
#[MapInputName(SnakeCaseMapper::class)]
class BannedUser extends TwitchData
{
    public function __construct(
        /**
         * @var string Banned user ID
         */
        public string $userId,

        /**
         * @var string Banned user login (lowercase)
         */
        public string $userLogin,

        /**
         * @var string Banned user display name
         */
        public string $userName,

        /**
         * @var string Moderator who issued the ban
         */
        public string $moderatorId,

        /**
         * @var string Moderator login
         */
        public string $moderatorLogin,

        /**
         * @var string Moderator display name
         */
        public string $moderatorName,

        /**
         * @var string Ban/timeout reason
         */
        public string $reason,

        /**
         * @var Carbon|null When the ban was created
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $createdAt = null,

        /**
         * @var Carbon|null When the timeout expires (null = permanent ban)
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $expiresAt = null,
    ) {}
}
