<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Feature;

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
            'scopes'       => ['user:read:email', 'channel:read:subscriptions'],
        ]);

        $this->assertTrue($user->hasScope('user:read:email'));
        $this->assertTrue($user->hasScope('channel:read:subscriptions'));
        $this->assertFalse($user->hasScope('channel:manage:redemptions'));
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

        $this->assertTrue($user->isTokenValid());

        $user->update(['expires_at' => now()->subHour()]);

        $this->assertFalse($user->isTokenValid());
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

        $this->assertDatabaseHas('twitch_users', [
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

        $this->assertNotNull($user);
        $this->assertEquals('123456789', $user->twitch_id);
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

        $this->assertNotNull($user);
        $this->assertEquals('testuser', $user->login);
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
            'scope'         => ['user:read:email'],
        ];

        $user->updateTokens($tokenData);

        $this->assertEquals('new-access-token', $user->access_token);
        $this->assertEquals('new-refresh-token', $user->refresh_token);
        $this->assertTrue($user->isTokenValid());
        $this->assertEquals(['user:read:email'], $user->scopes);
    }
}
