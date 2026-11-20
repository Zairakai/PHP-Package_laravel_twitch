<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Drops;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * One entry of the `events` list of a `drop.entitlement.grant` notification.
 */
#[MapInputName(SnakeCaseMapper::class)]
class DropEntitlementGrant extends TwitchData
{
    public function __construct(
        public string $id,
        public DropEntitlementData $data,
    ) {}
}
