<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Drops;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents the update status for a batch of entitlements.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#update-drops-entitlements
 */
#[MapInputName(SnakeCaseMapper::class)]
class EntitlementStatus extends Data
{
    public function __construct(
        /**
         * @var string Update status: SUCCESS, INVALID_ID, INCORRECT_ITEM_TYPE, ITEM_ALREADY_CLAIMED, FULFILLMENT_FAILED
         */
        public string $status,

        /**
         * @var array<int, string> Entitlement IDs that share this status
         */
        public array $ids = [],
    ) {}
}
