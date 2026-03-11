<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Moderation;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a VIP user in a broadcaster's channel.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-vips
 */
#[MapInputName(SnakeCaseMapper::class)]
class Vip extends Data
{
    public function __construct(
        /**
         * @var string VIP user ID
         */
        public string $userId,

        /**
         * @var string VIP user login (lowercase)
         */
        public string $userLogin,

        /**
         * @var string VIP user display name
         */
        public string $userName,
    ) {}
}
