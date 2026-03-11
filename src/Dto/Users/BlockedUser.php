<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Users;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a user that the authenticated user has blocked.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-user-block-list
 */
#[MapInputName(SnakeCaseMapper::class)]
class BlockedUser extends Data
{
    public function __construct(
        /**
         * @var string Blocked user ID
         */
        public string $userId,

        /**
         * @var string Blocked user login (lowercase)
         */
        public string $userLogin,

        /**
         * @var string Blocked user display name
         */
        public string $displayName,
    ) {}
}
