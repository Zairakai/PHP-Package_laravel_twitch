<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Users;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents whether a user has authorized the application, and the scopes
 * granted, as returned by Get Authorization By User.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-authorization-by-user
 */
#[MapInputName(SnakeCaseMapper::class)]
class UserAuthorization extends Data
{
    public function __construct(
        /**
         * @var string The user's ID
         */
        public string $userId,

        /**
         * @var string The user's display name
         */
        public string $userName,

        /**
         * @var string The user's login name
         */
        public string $userLogin,

        /**
         * @var array<string> The scopes the user has granted to the client ID
         */
        public array $scopes,

        /**
         * @var bool Whether the user has authorized this application
         */
        public bool $hasAuthorized,
    ) {}
}
