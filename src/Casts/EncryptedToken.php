<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

/**
 * Stores an access or refresh token encrypted with the application key.
 *
 * Unlike Laravel's `encrypted` cast, a value that is not encrypted (a token stored before the package encrypted
 * them) is returned as it is instead of throwing: the application keeps working after the update, and the token
 * is encrypted the next time it is saved, or at once by `php artisan twitch:encrypt-tokens`.
 *
 * @implements CastsAttributes<string|null, string|null>
 */
final class EncryptedToken implements CastsAttributes
{
    /**
     * @param array<string, mixed> $attributes
     */
    public function get(
        Model $model,
        string $key,
        mixed $value,
        array $attributes,
    ): ?string {
        if (! is_string($value) || '' === $value) {
            return null;
        }

        try {
            return Crypt::decryptString($value);
        }
        catch (DecryptException) {
            return $value;
        }
    }

    /**
     * @param array<string, mixed> $attributes
     */
    public function set(
        Model $model,
        string $key,
        mixed $value,
        array $attributes,
    ): ?string {
        if (! is_string($value) || '' === $value) {
            return null;
        }

        return Crypt::encryptString($value);
    }
}
