<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Feature;

use Illuminate\Database\QueryException;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Models\TwitchUser;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class TwitchUserModelTest extends TestCase
{
    #[Test]
    public function it_can_check_scopes(): void
    {
        $user = TwitchUser::create([
            'twitch_id'    => '123456789',
            'login'        => 'testuser',
            'display_name' => 'Test User',
            'scopes'       => [
                'user:read:email',
                'channel:read:subscriptions',
            ],
        ]);

        self::assertTrue($user->hasScope('user:read:email'));
        self::assertTrue($user->hasScope('channel:read:subscriptions'));
        self::assertFalse($user->hasScope('channel:manage:redemptions'));
    }

    #[Test]
    public function it_can_check_token_validity(): void
    {
        $user = TwitchUser::create([
            'twitch_id'    => '123456789',
            'login'        => 'testuser',
            'display_name' => 'Test User',
            'expires_at'   => now()->addHour(),
        ]);

        self::assertTrue($user->isTokenValid());

        $user->update([
            'expires_at' => now()->subHour(),
        ]);

        self::assertFalse($user->isTokenValid());
    }

    #[Test]
    public function it_can_create_twitch_user(): void
    {
        TwitchUser::create([
            'twitch_id'         => '123456789',
            'login'             => 'testuser',
            'display_name'      => 'Test User',
            'type'              => '',
            'broadcaster_type'  => '',
            'description'       => 'A test user',
            'profile_image_url' => 'https://example.com/profile.jpg',
            'email'             => 'test@example.com',
            'created_at_twitch' => now(),
        ]);

        self::assertDatabaseHas('twitch_users', [
            'twitch_id' => '123456789',
            'login'     => 'testuser',
        ]);
    }

    #[Test]
    public function it_can_find_user_by_login(): void
    {
        TwitchUser::create([
            'twitch_id'    => '123456789',
            'login'        => 'testuser',
            'display_name' => 'Test User',
        ]);

        $user = TwitchUser::findByLogin('testuser');

        self::assertNotNull($user);
        self::assertEquals('123456789', $user->twitch_id);
    }

    #[Test]
    public function it_can_find_user_by_twitch_id(): void
    {
        TwitchUser::create([
            'twitch_id'    => '123456789',
            'login'        => 'testuser',
            'display_name' => 'Test User',
        ]);

        $user = TwitchUser::findByTwitchId('123456789');

        self::assertNotNull($user);
        self::assertEquals('testuser', $user->login);
    }

    #[Test]
    public function it_can_update_tokens(): void
    {
        $user = TwitchUser::create([
            'twitch_id'    => '123456789',
            'login'        => 'testuser',
            'display_name' => 'Test User',
        ]);

        $tokenData = [
            'access_token'  => 'new-access-token',
            'refresh_token' => 'new-refresh-token',
            'expires_in'    => 3600,
            'scope'         => [
                'user:read:email',
            ],
        ];

        $user->updateTokens($tokenData);

        self::assertEquals('new-access-token', $user->access_token);
        self::assertEquals('new-refresh-token', $user->refresh_token);
        self::assertTrue($user->isTokenValid());
        self::assertEquals([
            'user:read:email',
        ], $user->scopes);
    }

    #[Test]
    public function the_id_is_what_identifies_a_user_not_the_login(): void
    {
        TwitchUser::create([
            'twitch_id'    => '1',
            'login'        => 'oldname',
            'display_name' => 'OldName',
        ]);

        // The login was changed on Twitch, then taken by someone else: two rows can carry it
        $second = TwitchUser::create([
            'twitch_id'    => '2',
            'login'        => 'oldname',
            'display_name' => 'OldName',
        ]);

        self::assertCount(2, TwitchUser::query()->where('login', 'oldname')->get());
        self::assertSame('2', $second->twitch_id);

        $this->expectException(QueryException::class);

        TwitchUser::create([
            'twitch_id'    => '1',
            'login'        => 'another',
            'display_name' => 'Another',
        ]);
    }

    #[Test]
    public function the_table_and_the_connection_come_from_the_configuration(): void
    {
        self::assertSame('twitch_users', new TwitchUser()->getTable());

        config([
            'twitch.database.table_prefix' => 'tw_',
            'twitch.database.connection'   => 'other',
        ]);

        self::assertSame('tw_users', new TwitchUser()->getTable());
        self::assertSame('other', new TwitchUser()->getConnectionName());

        // Back to the defaults: the migrations of the test run on them
        config([
            'twitch.database.table_prefix' => 'twitch_',
            'twitch.database.connection'   => null,
        ]);
    }
}
