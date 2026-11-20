<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Feature;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\PendingCommand;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Models\TwitchUser;
use Zairakai\LaravelTwitch\Tests\TestCase;

/**
 * The tokens are stored encrypted, and a token stored in clear before that still reads.
 */
final class TokenStorageTest extends TestCase
{
    #[Test]
    public function it_encrypts_the_tokens_stored_in_clear_and_only_those(): void
    {
        $this->insertClearUser(
            '1',
            'legacy-access',
            'legacy-refresh',
        );
        $already = TwitchUser::create([
            'twitch_id'    => '2',
            'login'        => 'other',
            'display_name' => 'Other',
            'access_token' => 'already-access',
        ]);
        $before  = DB::table('twitch_users')->where('id', $already->id)->value('access_token');

        $this->runCommand('twitch:encrypt-tokens', '1 user(s)');

        $raw = DB::table('twitch_users')->where('twitch_id', '1')->first();
        self::assertNotNull($raw);
        self::assertSame('legacy-access', $this->decrypt($raw->access_token));
        self::assertSame('legacy-refresh', $this->decrypt($raw->refresh_token));
        self::assertSame($before, DB::table('twitch_users')->where('id', $already->id)->value('access_token'));

        $this->runCommand('twitch:encrypt-tokens', '0 user(s)');
    }

    #[Test]
    public function it_keeps_a_missing_token_null(): void
    {
        $twitchUser = TwitchUser::create([
            'twitch_id'    => '1',
            'login'        => 'someone',
            'display_name' => 'Someone',
        ]);

        self::assertNull(DB::table('twitch_users')->where('id', $twitchUser->id)->value('access_token'));
        self::assertNull(TwitchUser::query()->findOrFail($twitchUser->id)->access_token);
    }

    #[Test]
    public function it_still_reads_a_token_that_was_stored_in_clear(): void
    {
        $this->insertClearUser(
            '1',
            'legacy-access',
            'legacy-refresh',
        );

        $twitchUser = TwitchUser::query()->firstOrFail();

        self::assertSame('legacy-access', $twitchUser->access_token);
        self::assertSame('legacy-refresh', $twitchUser->refresh_token);
    }

    #[Test]
    public function it_stores_the_tokens_encrypted_and_reads_them_back(): void
    {
        $twitchUser = TwitchUser::create([
            'twitch_id'     => '1',
            'login'         => 'someone',
            'display_name'  => 'Someone',
            'access_token'  => 'plain-access',
            'refresh_token' => 'plain-refresh',
        ]);

        $raw = DB::table('twitch_users')->where('id', $twitchUser->id)->first();

        self::assertNotNull($raw);
        self::assertNotSame('plain-access', $raw->access_token);
        self::assertSame('plain-access', $this->decrypt($raw->access_token));
        self::assertSame('plain-refresh', $this->decrypt($raw->refresh_token));
        self::assertSame('plain-access', TwitchUser::query()->findOrFail($twitchUser->id)->access_token);
        self::assertSame('plain-refresh', TwitchUser::query()->findOrFail($twitchUser->id)->refresh_token);
    }

    private function decrypt(mixed $value): string
    {
        self::assertIsString($value);

        return Crypt::decryptString($value);
    }

    private function insertClearUser(
        string $id,
        string $access,
        string $refresh,
    ): void {
        DB::table('twitch_users')->insert([
            'twitch_id'     => $id,
            'login'         => 'user' . $id,
            'display_name'  => 'User ' . $id,
            'access_token'  => $access,
            'refresh_token' => $refresh,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }

    private function runCommand(string $command, string $expected): void
    {
        $pending = $this->artisan($command);
        self::assertInstanceOf(PendingCommand::class, $pending);
        $pending->expectsOutputToContain($expected)->assertSuccessful();
    }
}
