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
     * Spatie declares `CreationContext` without its generic in `Cast::cast()`: no generic written here satisfies PHPStan's
     * contravariance check against it.
     *
     * @param array<string, mixed>  $properties
     * @param CreationContext<Data> $context
     *
     * @phpstan-ignore method.childParameterType
     */
    public function cast(
        DataProperty $property,
        mixed $value,
        array $properties,
        CreationContext $context,
    ): Carbon|Uncastable|null {
        // Twitch sends an empty string for "no date" (offline channel, permanent ban...): that is a null.
        if ('' === $value) {
            return null;
        }

        if ($this->isUnixSeconds($value)) {
            return $this->fromUnixSeconds($value);
        }

        return is_string($value)
            ? Date::parse($value)
            : Uncastable::create();
    }

    /**
     * Twitch sends some dates as Unix seconds (Get Ad Schedule), with 0 meaning "none".
     */
    private function fromUnixSeconds(int|string $seconds): ?Carbon
    {
        return 0 === (int) $seconds
            ? null
            : Date::createFromTimestamp((int) $seconds);
    }

    /**
     * @phpstan-assert-if-true int|numeric-string $value
     */
    private function isUnixSeconds(mixed $value): bool
    {
        return is_int($value)
            || (is_string($value) && ctype_digit($value));
    }
}
