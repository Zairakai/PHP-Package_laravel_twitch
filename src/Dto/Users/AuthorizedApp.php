<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Users;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents an app that the user has authorized to access their Twitch account.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-user-auth-details
 */
#[MapInputName(SnakeCaseMapper::class)]
class AuthorizedApp extends Data
{
    public function __construct(
        /**
         * @var string OAuth client ID of the authorized app
         */
        public string $clientId,

        /**
         * @var string App description
         */
        public string $description,

        /**
         * @var array<string> List of scopes the app was granted
         */
        public array $scopes,

        /**
         * @var Carbon|null When the authorization was first granted
         */
        public ?Carbon $createdAt = null,

        /**
         * @var Carbon|null When the authorization was last updated
         */
        public ?Carbon $updatedAt = null,
    ) {}
}
