<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Chat;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a user's chat color.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-user-chat-color
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChatColor extends Data
{
    public function __construct(
        /**
         * @var string User ID
         */
        public string $userId,

        /**
         * @var string User login (lowercase)
         */
        public string $userLogin,

        /**
         * @var string User display name
         */
        public string $userName,

        /**
         * @var string Color hex code (e.g. #FF4500)
         */
        public string $color,
    ) {}
}
