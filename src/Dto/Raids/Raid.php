<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Raids;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a Twitch raid.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#start-a-raid
 */
#[MapInputName(SnakeCaseMapper::class)]
class Raid extends Data
{
    public function __construct(
        /**
         * @var Carbon|null When the raid was created
         */
        public ?Carbon $createdAt = null,

        /**
         * @var bool Whether the raid is mature content
         */
        public bool $isMature = false,
    ) {}
}
