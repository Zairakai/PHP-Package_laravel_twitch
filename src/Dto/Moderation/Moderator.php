<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Moderation;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a channel moderator.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-moderators
 */
#[MapInputName(SnakeCaseMapper::class)]
class Moderator extends Data
{
    public function __construct(
        /**
         * @var string Moderator user ID
         */
        public string $userId,

        /**
         * @var string Moderator login (lowercase)
         */
        public string $userLogin,

        /**
         * @var string Moderator display name
         */
        public string $userName,
    ) {}
}
