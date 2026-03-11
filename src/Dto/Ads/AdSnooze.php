<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Ads;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents the result of snoozing the next scheduled ad.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#snooze-next-ad
 */
#[MapInputName(SnakeCaseMapper::class)]
class AdSnooze extends Data
{
    public function __construct(
        /**
         * @var string Broadcaster ID
         */
        public string $broadcasterId,

        /**
         * @var int Number of snoozes still available
         */
        public int $snoozeCount,

        /**
         * @var Carbon|null When the next snooze becomes available
         */
        public ?Carbon $snoozeRefreshAt = null,

        /**
         * @var Carbon|null When the next ad is scheduled
         */
        public ?Carbon $nextAdAt = null,
    ) {}
}
