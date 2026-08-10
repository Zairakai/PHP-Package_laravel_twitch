<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Casts;

use Carbon\Carbon;
use Illuminate\Support\Facades\Date;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Casts\Uncastable;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

/**
 * Casts Twitch RFC3339 timestamps to Carbon.
 *
 * Twitch sends variable fractional-second precision (`.123Z` millisecond,
 * `.171067Z` microsecond, or none at all) and spatie/laravel-data's default
 * DateTimeInterfaceCast only tries a single fixed format (DATE_ATOM, no
 * fractional seconds) - it rejects every real Twitch example payload.
 * Carbon::parse() handles all ISO8601 variants natively, no format guessing
 * needed.
 */
class FlexibleDateTimeCast implements Cast
{
    /**
     * @param array<string, mixed>  $properties
     * @param CreationContext<Data> $context
     */
    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): Carbon|Uncastable
    {
        if (! is_string($value) || '' === $value) {
            return Uncastable::create();
        }

        return Date::parse($value);
    }
}
