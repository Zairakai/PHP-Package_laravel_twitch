<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\HypeTrain;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a broadcaster participating in a shared Hype Train, as returned
 * nested inside Get Hype Train Status.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-hype-train-status
 */
#[MapInputName(SnakeCaseMapper::class)]
class HypeTrainParticipant extends Data
{
    public function __construct(
        /**
         * @var string ID of the participating broadcaster
         */
        public string $broadcasterUserId,

        /**
         * @var string Login name of the participating broadcaster
         */
        public string $broadcasterUserLogin,

        /**
         * @var string Display name of the participating broadcaster
         */
        public string $broadcasterUserName,
    ) {}
}
