<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Raids;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents a Twitch raid.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#start-a-raid
 */
#[MapInputName(SnakeCaseMapper::class)]
class Raid extends TwitchData
{
    public function __construct(
        /**
         * @var Carbon|null When the raid was created
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $createdAt = null,

        /**
         * @var bool Whether the raid is mature content
         */
        public bool $isMature = false,
    ) {}
}
