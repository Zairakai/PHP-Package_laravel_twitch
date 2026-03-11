<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\ChannelPoints;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a channel point reward redemption.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-custom-reward-redemption
 */
#[MapInputName(SnakeCaseMapper::class)]
class Redemption extends Data
{
    public function __construct(
        /**
         * @var string Broadcaster ID
         */
        public string $broadcasterId,

        /**
         * @var string Broadcaster login (lowercase)
         */
        public string $broadcasterLogin,

        /**
         * @var string Broadcaster display name
         */
        public string $broadcasterName,

        /**
         * @var string Redemption ID
         */
        public string $id,

        /**
         * @var string Redeemer user ID
         */
        public string $userId,

        /**
         * @var string Redeemer login (lowercase)
         */
        public string $userLogin,

        /**
         * @var string Redeemer display name
         */
        public string $userName,

        /**
         * @var string Status: CANCELED, FULFILLED, UNFULFILLED
         */
        public string $status,

        /**
         * @var string Reward ID
         */
        public string $rewardId,

        /**
         * @var string Reward title
         */
        public string $rewardTitle,

        /**
         * @var int Reward cost
         */
        public int $rewardCost,

        /**
         * @var string Reward prompt
         */
        public string $rewardPrompt,

        /**
         * @var string|null User input (if required)
         */
        public ?string $userInput = null,

        /**
         * @var Carbon|null When the redemption occurred
         */
        public ?Carbon $redeemedAt = null,
    ) {}
}
