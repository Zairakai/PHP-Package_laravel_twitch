<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\GuestStar;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a Guest Star session.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-guest-star-session
 */
#[MapInputName(SnakeCaseMapper::class)]
class GuestStarSession extends Data
{
    public function __construct(
        /**
         * @var string Session ID
         */
        public string $id,

        /**
         * @var list<array<string, mixed>> Guests in the session with slot assignments
         */
        public array $guests = [],
    ) {}
}
