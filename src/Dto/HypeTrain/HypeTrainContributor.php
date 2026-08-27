<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\HypeTrain;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a top contributor to a Hype Train, as returned nested inside
 * Get Hype Train Status.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-hype-train-status
 */
#[MapInputName(SnakeCaseMapper::class)]
class HypeTrainContributor extends Data
{
    public function __construct(
        /**
         * @var string ID of the contributing user
         */
        public string $userId,

        /**
         * @var string Login name of the contributing user
         */
        public string $userLogin,

        /**
         * @var string Display name of the contributing user
         */
        public string $userName,

        /**
         * @var string Contribution method: bits, subscription, or other
         */
        public string $type,

        /**
         * @var int Total points contributed for this type
         */
        public int $total,
    ) {}
}
