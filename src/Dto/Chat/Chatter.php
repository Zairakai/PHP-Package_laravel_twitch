<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Chat;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a user currently in a broadcaster's chat.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-chatters
 */
#[MapInputName(SnakeCaseMapper::class)]
class Chatter extends Data
{
    public function __construct(
        /**
         * @var string Chatter user ID
         */
        public string $userId,

        /**
         * @var string Chatter login (lowercase)
         */
        public string $userLogin,

        /**
         * @var string Chatter display name
         */
        public string $userName,
    ) {}
}
