<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Console;

use Illuminate\Console\Command;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Zairakai\LaravelTwitch\Models\TwitchUser;

/**
 * Encrypts the tokens that were stored in clear before the package encrypted them. Safe to run again.
 */
final class EncryptTokensCommand extends Command
{
    protected $description = 'Encrypt the Twitch access and refresh tokens that are still stored in clear';

    protected $signature = 'twitch:encrypt-tokens';

    public function handle(): int
    {
        $table   = new TwitchUser()->getTable();
        $changed = 0;

        DB::table($table)->select([
            'id',
            'access_token',
            'refresh_token',
        ])->orderBy('id')->each(function (object $row) use ($table, &$changed): void {
            $updates = [];

            foreach ([
                'access_token',
                'refresh_token',
            ] as $column) {
                $value = $row->{$column} ?? null;

                if (
                    is_string($value)
                    && '' !== $value
                    && ! $this->isEncrypted($value)
                ) {
                    $updates[$column] = Crypt::encryptString($value);
                }
            }

            if ([] !== $updates) {
                DB::table($table)->where('id', $row->id)->update($updates);
                $changed++;
            }
        });

        $this->info(sprintf('%d user(s) had tokens in clear: now encrypted.', $changed));

        return self::SUCCESS;
    }

    private function isEncrypted(string $value): bool
    {
        try {
            Crypt::decryptString($value);

            return true;
        }
        catch (DecryptException) {
            return false;
        }
    }
}
