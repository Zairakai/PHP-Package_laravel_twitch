<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Ads;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents the result of snoozing the next scheduled ad.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#snooze-next-ad
 */
#[MapInputName(SnakeCaseMapper::class)]
class AdSnooze extends TwitchData
{
    public function __construct(
        /**
         * @var string Broadcaster ID
         */
        public ?string $broadcasterId = null,

        /**
         * @var int Number of snoozes still available
         */
        public int $snoozeCount = 0,

        /**
         * @var Carbon|null When the next snooze becomes available
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $snoozeRefreshAt = null,

        /**
         * @var Carbon|null When the next ad is scheduled
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $nextAdAt = null,
    ) {}
}
