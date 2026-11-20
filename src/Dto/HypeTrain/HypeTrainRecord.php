<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\HypeTrain;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents a Hype Train record (all-time high or shared all-time high), as
 * returned nested inside Get Hype Train Status.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-hype-train-status
 */
#[MapInputName(SnakeCaseMapper::class)]
class HypeTrainRecord extends TwitchData
{
    public function __construct(
        /**
         * @var int Level of the record Hype Train
         */
        public int $level,

        /**
         * @var int Total points contributed to the record Hype Train
         */
        public int $total,

        /**
         * @var Carbon When the record was achieved
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public Carbon $achievedAt,
    ) {}
}
