<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Moderation;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents the result of banning or timing out a user.
 *
 * Returned by banUser() and timeoutUser(). For the list of banned users, see BannedUser.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#ban-user
 */
#[MapInputName(SnakeCaseMapper::class)]
class BanResult extends Data
{
    public function __construct(
        /**
         * @var string Broadcaster ID
         */
        public string $broadcasterId,

        /**
         * @var string Moderator who issued the ban
         */
        public string $moderatorId,

        /**
         * @var string Banned user ID
         */
        public string $userId,

        /**
         * @var string|null When the ban was created (RFC3339)
         */
        public ?string $createdAt = null,

        /**
         * @var string|null When the timeout ends (null = permanent ban)
         */
        public ?string $endTime = null,
    ) {}
}
