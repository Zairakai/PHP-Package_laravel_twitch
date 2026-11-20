<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Support;

/**
 * Twitch sends numbers and booleans as strings in places ("1", "false", "60"): these are read as what they are.
 * A real number is never turned into a boolean: only 0 and 1 are flags, and only for a property declared bool.
 */
final class ScalarCoercion
{
    /**
     * @param 'bool'|'int'|'float' $type
     */
    public static function coerce(mixed $value, string $type): mixed
    {
        if (is_bool($value) || null === $value) {
            return $value;
        }

        return 'bool' === $type
            ? self::toBool($value)
            : self::toNumber($value, $type);
    }

    private static function toBool(mixed $value): mixed
    {
        if (is_string($value)) {
            return match (strtolower(trim($value))) {
                'true', '1', 'yes', 'on'      => true,
                'false', '0', 'no', 'off', '' => false,
                default                       => $value,
            };
        }

        // Only 0 and 1 are flags: any other integer (a count, a cost) is left as it is.
        return is_int($value) && in_array($value, [
            0,
            1,
        ], true)
            ? 1 === $value
            : $value;
    }

    private static function toNumber(mixed $value, string $type): mixed
    {
        if (! is_string($value) || ! is_numeric($value)) {
            return $value;
        }

        if ('float' === $type) {
            return (float) $value;
        }

        return (string) (int) $value === trim($value)
            ? (int) $value
            : $value;
    }
}
