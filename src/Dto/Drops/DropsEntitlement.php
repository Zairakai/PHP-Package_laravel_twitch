<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Drops;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a Drops entitlement granted to a user.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-drops-entitlements
 */
#[MapInputName(SnakeCaseMapper::class)]
class DropsEntitlement extends Data
{
    public function __construct(
        /**
         * @var string Entitlement ID
         */
        public string $id,

        /**
         * @var string Benefit ID from the Drop campaign
         */
        public string $benefitId,

        /**
         * @var string User ID who received the entitlement
         */
        public string $userId,

        /**
         * @var string Game ID associated with the entitlement
         */
        public string $gameId,

        /**
         * @var string Fulfillment status: CLAIMED or FULFILLED
         */
        public string $fulfillmentStatus,

        /**
         * @var Carbon|null When the entitlement was granted
         */
        public ?Carbon $timestamp = null,

        /**
         * @var Carbon|null When the fulfillment status was last updated
         */
        public ?Carbon $updatedAt = null,
    ) {}
}
