<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Drops;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * The entitlement of one `drop.entitlement.grant` notification.
 *
 * @see https://dev.twitch.tv/docs/eventsub/reference/drop
 */
#[MapInputName(SnakeCaseMapper::class)]
class DropEntitlementData extends TwitchData
{
    public function __construct(
        public string $organizationId,
        public string $categoryId,
        public string $categoryName,
        public string $campaignId,
        public string $userId,
        public string $userName,
        public string $userLogin,
        public string $entitlementId,
        public string $benefitId,
        #[WithCast(FlexibleDateTimeCast::class)]
        public Carbon $createdAt,
    ) {}
}
