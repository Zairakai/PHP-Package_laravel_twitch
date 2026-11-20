<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Zairakai\LaravelTwitch\Http\Controllers\TwitchAuthController;

/*
|--------------------------------------------------------------------------
| Twitch Package Routes
|--------------------------------------------------------------------------
|
| Here are routes for the Laravel Twitch package. These routes handle
| OAuth authentication and webhook endpoints for Twitch integration.
|
*/

Route::prefix('twitch')->name('twitch.')->group(function (): void {
    // OAuth routes: they keep the state and the user in the session, so they need the web middleware group
    Route::middleware('web')->group(function (): void {
        Route::get('/auth', [
            TwitchAuthController::class,
            'redirect',
        ])->name('auth');
        Route::get('/auth/callback', [
            TwitchAuthController::class,
            'callback',
        ])->name('auth.callback');
    });

    // Webhook routes
    Route::post('/webhook', [
        TwitchAuthController::class,
        'webhook',
    ])->name('webhook');
});
