<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Facades;

use Illuminate\Support\Facades\Facade;
use Zairakai\LaravelTwitch\Services\TwitchOAuthService;

/**
 * @method static string getAuthorizationUrl(array $scopes = null, string $state = null)
 * @method static array getAccessToken(string $code, string $state = null)
 * @method static array refreshToken(string $refreshToken)
 * @method static array validateToken(string $accessToken)
 * @method static bool revokeToken(string $accessToken)
 *
 * @see TwitchOAuthService
 */
class TwitchOAuth extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @codeCoverageIgnore
     */
    protected static function getFacadeAccessor(): string
    {
        return 'twitch.oauth';
    }
}
