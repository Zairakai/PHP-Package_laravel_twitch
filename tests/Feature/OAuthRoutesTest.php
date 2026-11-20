<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Feature;

use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class OAuthRoutesTest extends TestCase
{
    #[Test]
    public function the_auth_route_redirects_to_twitch_with_a_state_kept_in_the_session(): void
    {
        config([
            'twitch.client_id'     => 'client',
            'twitch.client_secret' => 'secret',
        ]);

        $response = $this->get('/twitch/auth');

        $response->assertRedirectContains('https://id.twitch.tv/oauth2/authorize');
        self::assertIsString(session('twitch_oauth_state'));
    }

    #[Test]
    public function the_callback_goes_back_to_a_url_or_to_a_route_name_of_the_configuration(): void
    {
        Route::get('/dashboard', static fn (): string => 'dashboard')->name('dashboard');

        config([
            'twitch.oauth.redirect_to' => '/somewhere',
        ]);
        $this->withSession([
            'twitch_oauth_state' => 'expected',
        ])->get('/twitch/auth/callback?code=abc&state=other')->assertRedirect('/somewhere');

        config([
            'twitch.oauth.redirect_to' => 'dashboard',
        ]);
        $this->withSession([
            'twitch_oauth_state' => 'expected',
        ])->get('/twitch/auth/callback?code=abc&state=other')->assertRedirect('/dashboard');
    }

    #[Test]
    public function the_callback_refuses_a_state_that_is_not_the_one_of_the_session(): void
    {
        // The callback goes back to the route `home` of the application
        Route::get('/', static fn (): string => 'home')->name('home');

        $response = $this->withSession([
            'twitch_oauth_state' => 'expected',
        ])->get('/twitch/auth/callback?code=abc&state=other');

        $response->assertSessionHasErrors('error');
    }

    #[Test]
    public function the_webhook_route_does_not_need_a_session(): void
    {
        $response = $this->postJson('/twitch/webhook', []);

        // Without a signature the message is refused (400), not a crash for the lack of a session
        $response->assertStatus(400);
    }
}
