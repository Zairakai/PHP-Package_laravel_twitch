<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Zairakai\LaravelTwitch\Exceptions\TwitchApiException;
use Zairakai\LaravelTwitch\Models\TwitchUser;
use Zairakai\LaravelTwitch\Services\TwitchOAuthService;

/**
 * Validates the stored access tokens, as Twitch requires of an app that keeps OAuth sessions: at startup, then every
 * hour. A token that is no longer valid is refreshed; when that fails the `twitch.token.invalid` event is dispatched
 * with the user, so that the application ends the sessions that use it.
 *
 * Schedule it every hour: `Schedule::command('twitch:validate-tokens')->hourly();`
 *
 * @see https://dev.twitch.tv/docs/authentication/validate-tokens/
 */
final class ValidateTokensCommand extends Command
{
    protected $description = 'Validate the stored Twitch access tokens and refresh the ones that are no longer valid';

    protected $signature = 'twitch:validate-tokens';

    public function handle(TwitchOAuthService $twitchOAuthService): int
    {
        $counts = [
            'valid'     => 0,
            'refreshed' => 0,
            'invalid'   => 0,
            'skipped'   => 0,
        ];

        foreach (TwitchUser::whereNotNull('access_token')->cursor() as $twitchUser) {
            $counts[$this->check($twitchOAuthService, $twitchUser)]++;
        }

        $this->info(sprintf(
            '%d valid, %d refreshed, %d invalid, %d not checked (Twitch or the network failed).',
            $counts['valid'],
            $counts['refreshed'],
            $counts['invalid'],
            $counts['skipped'],
        ));

        return self::SUCCESS;
    }

    /**
     * @return 'valid'|'refreshed'|'invalid'|'skipped'
     */
    private function check(TwitchOAuthService $twitchOAuthService, TwitchUser $twitchUser): string
    {
        $token = $twitchUser->access_token;

        if (! is_string($token)) {
            return 'skipped';
        }

        $state = $this->validate(
            $twitchOAuthService,
            $twitchUser,
            $token,
        );

        if ('invalid' !== $state) {
            return $state;
        }

        return $this->refresh($twitchOAuthService, $twitchUser)
            ? 'refreshed'
            : $this->lose($twitchUser);
    }

    /**
     * @return 'invalid'
     */
    private function lose(TwitchUser $twitchUser): string
    {
        $twitchUser->forceFill([
            'expires_at' => now(),
        ])->save();

        Log::warning('A Twitch token is no longer valid and could not be refreshed.', [
            'twitch_id' => $twitchUser->twitch_id,
        ]);
        event('twitch.token.invalid', [
            $twitchUser,
        ]);

        return 'invalid';
    }

    private function refresh(TwitchOAuthService $twitchOAuthService, TwitchUser $twitchUser): bool
    {
        $refreshToken = $twitchUser->refresh_token;

        if (
            ! is_string($refreshToken)
            || '' === $refreshToken
        ) {
            return false;
        }

        try {
            $twitchUser->updateTokens($twitchOAuthService->refreshToken($refreshToken));

            return true;
        }
        catch (TwitchApiException) {
            // The refresh token is no good either: the token is lost.
            return false;
        }
    }

    /**
     * @param array<mixed> $info Answer of Twitch to the validation of the token
     */
    private function store(TwitchUser $twitchUser, array $info): void
    {
        $left = is_numeric($info['expires_in'] ?? null)
            ? (int) $info['expires_in']
            : 0;

        $twitchUser->forceFill([
            'expires_at' => now()->addSeconds($left),
            'scopes'     => is_array($info['scopes'] ?? null)
                ? $info['scopes']
                : $twitchUser->scopes,
        ])->save();
    }

    /**
     * @return 'valid'|'invalid'|'skipped'
     */
    private function validate(
        TwitchOAuthService $twitchOAuthService,
        TwitchUser $twitchUser,
        string $token,
    ): string {
        try {
            $this->store($twitchUser, $twitchOAuthService->validateToken($token));

            return 'valid';
        }
        catch (TwitchApiException $twitchApiException) {
            // Only a 401 says that the token is invalid: anything else (network, Twitch down) says nothing.
            return 401 === $twitchApiException->status()
                ? 'invalid'
                : 'skipped';
        }
    }
}
