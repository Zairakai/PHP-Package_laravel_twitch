<p align="center">
  <img src="https://gitlab.com/zairakai/php-packages/laravel-twitch/-/raw/main/assets/icon.png" alt="Laravel Twitch" width="160">
</p>

# Laravel Twitch

[![Main][pipeline-main-badge]][pipeline-main-link]
[![Develop][pipeline-develop-badge]][pipeline-develop-link]
[![Coverage][coverage-badge]][coverage-link]

[![GitLab Release][gitlab-release-badge]][gitlab-release]
[![Packagist][packagist-badge]][packagist]
[![Docs][docs-badge]][docs]
[![Downloads][downloads-badge]][packagist]
[![License][license-badge]][license]

[![PHP][php-badge]][php]
[![Laravel][laravel-badge]][laravel]
[![Static Analysis][phpstan-badge]][phpstan]
[![Code Style][pint-badge]][pint]

Twitch integration for Laravel: the Helix API with typed responses, OAuth, and EventSub (webhook, WebSocket and conduit) with a typed event for each notification.

**Documentation: [laravel-twitch-8a8c1e.gitlab.io][docs]**

---

## Features

- **Helix API**: the 147 routes of the reference, through the `Twitch` facade. Every answer is a typed DTO: Twitch sends flags as `"1"` or `"false"` and numbers as strings, the DTOs give `bool`, `int` and `Carbon`.
- **OAuth 2.0**: authorization code flow, refresh, validation and revocation, through the `TwitchOAuth` facade, with the routes and the controller to connect a user.
- **EventSub**: subscriptions over webhook, WebSocket or conduit, signature check, replay and duplicate protection, and one typed event for each of the 79 subscription types.
- **Reliable requests**: a 401 renews the token once, a 429 waits for `Ratelimit-Reset`, and a rate limiter keeps the calls under the limit of Twitch.
- **Token storage**: `TwitchUser` model, tokens encrypted with `APP_KEY`, and a command that validates them every hour.

## Requirements

PHP 8.4 or higher and Laravel 12 or 13.

## Install

```bash
composer require zairakai/laravel-twitch
php artisan vendor:publish --tag=config
php artisan migrate
```

`.env`:

```env
TWITCH_CLIENT_ID=your_client_id
TWITCH_CLIENT_SECRET=your_client_secret
TWITCH_REDIRECT_URI=https://your-app.com/twitch/auth/callback
TWITCH_WEBHOOK_SECRET=your_webhook_secret
```

The migration creates the `twitch_users` table of the `TwitchUser` model: the user, identified by its Twitch ID (the login can change and be taken by someone else, so it is only indexed), and its tokens. Without the OAuth connection and the stored tokens, the table is not used. To keep the tokens in another database, set `twitch.database.connection` (and `table_prefix`). To own the migration, publish it (`--tag=twitch-migrations`) and set `TWITCH_LOAD_MIGRATIONS=false`.

## Usage

```php
use Zairakai\LaravelTwitch\Facades\Twitch;

$games   = Twitch::getTopGames();
$users   = Twitch::getUsers(logins: 'username');
$streams = Twitch::getStreams(userIds: ['12345', '67890']);
$results = Twitch::searchChannels('gaming');
```

A call that needs a user token uses the one given with `Twitch::setAccessToken($token)`; the others use the app token, which the package gets and renews by itself.

<details>
<summary>Connect a user (OAuth)</summary>

The package registers three routes: `GET /twitch/auth` (redirect to Twitch), `GET /twitch/auth/callback` and `POST /twitch/webhook`. The first two use the `web` middleware group. The callback creates or updates the `TwitchUser`, stores its id in the session under `twitch_user_id` and goes to `twitch.oauth.redirect_to`: a route name (`home` by default) or a URL (a value that starts with `/` or `http`). The redirect URI to register in the Twitch console is the one of the callback.

```php
use Zairakai\LaravelTwitch\Facades\TwitchOAuth;

// Your own flow, without the routes of the package
$url   = TwitchOAuth::getAuthorizationUrl(['user:read:email', 'channel:read:subscriptions'], $state);
$token = TwitchOAuth::getAccessToken($code, $state);
$new   = TwitchOAuth::refreshToken($refreshToken);
```

To get a new user token when Twitch answers 401, give the service a refresher:

```php
Twitch::setTokenRefresher(fn (): ?string => $this->renewAndReturnTheAccessToken());
```

</details>

<details>
<summary>EventSub</summary>

```php
Twitch::createEventSubSubscription(
    type: 'stream.online',
    condition: ['broadcaster_user_id' => $broadcasterId],
    callbackUrl: route('twitch.webhook'),
    secret: config('twitch.eventsub.webhook_secret'),
);
```

The version of the type is the latest one unless you give `version:`. Over WebSocket or a conduit, use `createEventSubWebSocketSubscription()` and `createEventSubConduitSubscription()`.

Each notification dispatches the Laravel event `twitch.{type}` with the typed DTO, then the version of the subscription:

```php
Event::listen('twitch.channel.follow', function (ChannelFollowEvent $event, ?string $version): void {
    // $event->userLogin, $event->followedAt (Carbon)...
});
```

A type that Twitch adds before the package knows it gives a `GenericEventSubEvent` (`type` and the raw `payload`): nothing is dropped. The webhook refuses a wrong signature (400), a message older than `eventsub.max_message_age` seconds, and a message ID already seen during `eventsub.dedupe_ttl` seconds. A revocation dispatches `twitch.eventsub.revoked`.

</details>

<details>
<summary>Errors</summary>

A failed call throws a `TwitchApiException` (the Guzzle exception is its `getPrevious()`). Whatever the endpoint, `$e->error` is a `TwitchError`: the HTTP `status`, a stable `code`, the English `message` of Twitch and a `context`.

```php
try {
    Twitch::getStreamKey($broadcasterId);
}
catch (TwitchApiException $e) {
    $e->errorCode();                 // 'missing_scope'
    $e->error->translationKey();     // 'twitch::errors.missing_scope'
    $e->error->translated();         // "Il manque une autorisation (scope) au jeton d'accès Twitch : channel:read:stream_key or channel_read."
}
```

Codes: `token_invalid`, `missing_scope`, `app_token_required`, `user_mismatch`, `client_mismatch`, `no_organization`, `multiple_filters`, `malformed_parameter`, `bad_identifiers`, `invalid_code`, `invalid_refresh_token`, then by status: `bad_request`, `unauthorized`, `forbidden`, `not_found`, `conflict`, `gone`, `unprocessable`, `rate_limited`, `server_error`, and `network` when Twitch cannot be reached. The translations are in the 129 languages of [laravel-lang](https://laravel-lang.com) (`lang/<locale>/errors.php`, namespace `twitch`): the package loads them all, nothing to deploy. To change a text, publish the languages you need with `php artisan twitch:lang fr de` (`--all`, `--list` and `--force` exist), or all of them with `--tag=twitch-translations`. English, French and the other major languages were translated with care; the rarer ones (for example `ak`, `bm`, `ln`, `lg`, `mni_Mtei`, `qu`, `rw`) were not reviewed by a native speaker: corrections are welcome. A language that is missing a key falls back to English.

An absence is not an error: a channel with no schedule gives a `Schedule` with no segment, not an exception.

</details>

<details>
<summary>Stored tokens</summary>

`access_token` and `refresh_token` of `TwitchUser` are encrypted with `APP_KEY`. Two commands:

| Command | What it does |
| --- | --- |
| `twitch:encrypt-tokens` | encrypts the tokens stored before the encryption existed |
| `twitch:validate-tokens` | validates every token, refreshes the invalid ones, and dispatches `twitch.token.invalid` for the ones that cannot be refreshed |

Twitch asks an app that keeps tokens to validate them every hour:

```php
Schedule::command('twitch:validate-tokens')->hourly();
```

</details>

<details>
<summary>Configuration</summary>

Key options of `config/twitch.php`:

| Key | Description |
| --- | --- |
| `client_id`, `client_secret` | credentials of the Twitch application |
| `redirect_uri` | OAuth callback URL (default: the route of the package, `/twitch/auth/callback`) |
| `oauth.redirect_to` | where the callback goes next: a route name or a URL |
| `scopes` | scopes asked by default |
| `api.timeout` | timeout of a request, in seconds |
| `api.retry.times`, `api.retry.sleep` | number of retries after a 429 and the wait, in milliseconds, when Twitch gives no reset time |
| `eventsub.webhook_secret`, `eventsub.webhook_callback_url` | secret of the signature check, and the callback used when `createEventSubSubscription()` is not given one |
| `eventsub.max_message_age` | oldest accepted message, in seconds (0 turns the check off) |
| `eventsub.dedupe_ttl` | how long a message ID is remembered, in seconds |
| `cache.enabled`, `cache.ttl.*` | cache of the public answers (user, stream, game, channel, top games, cheermotes, badges, emotes), in seconds |
| `rate_limit.enabled`, `rate_limit.requests_per_minute`, `rate_limit.burst_limit` | token bucket shared through the cache: `burst_limit` calls at once, refilled at `requests_per_minute` per minute |
| `database.connection`, `database.table_prefix`, `database.load_migrations` | where the tokens are stored, and whether the package loads its migration |

`badges` is not used yet. Which events to subscribe to is up to the application: it calls `createEventSubSubscription()` for the ones it wants.

</details>

## Development

```bash
make ci        # quality, tests and Bats
make test      # PHPUnit
make quality   # Pint, PHPStan, Rector, PHPInsights, Markdownlint, ShellCheck
```

## Getting Help

[![License][license-badge]][license]
[![Security Policy][security-badge]][security]
[![Issues][issues-badge]][issues]

**Made with ❤️ by [Zairakai][ecosystem]**

## Statistics

![Statistics of laravel-twitch][stats-card]

[pipeline-main-badge]: https://gitlab.com/zairakai/php-packages/laravel-twitch/badges/main/pipeline.svg?ignore_skipped=true&key_text=Main
[pipeline-main-link]: https://gitlab.com/zairakai/php-packages/laravel-twitch/commits/main
[pipeline-develop-badge]: https://gitlab.com/zairakai/php-packages/laravel-twitch/badges/develop/pipeline.svg?ignore_skipped=true&key_text=Develop
[pipeline-develop-link]: https://gitlab.com/zairakai/php-packages/laravel-twitch/commits/develop
[coverage-badge]: https://gitlab.com/zairakai/php-packages/laravel-twitch/badges/main/coverage.svg
[coverage-link]: https://gitlab.com/zairakai/php-packages/laravel-twitch/-/commits/main
[gitlab-release-badge]: https://img.shields.io/gitlab/v/release/zairakai/php-packages/laravel-twitch?logo=gitlab
[gitlab-release]: https://gitlab.com/zairakai/php-packages/laravel-twitch/-/releases
[packagist-badge]: https://img.shields.io/packagist/v/zairakai/laravel-twitch
[packagist]: https://packagist.org/packages/zairakai/laravel-twitch
[downloads-badge]: https://img.shields.io/packagist/dt/zairakai/laravel-twitch
[license-badge]: https://img.shields.io/badge/license-MIT-blue.svg
[license]: ./LICENSE
[security-badge]: https://img.shields.io/badge/security-scanned-green.svg
[security]: ./SECURITY.md
[issues-badge]: https://img.shields.io/gitlab/issues/open-raw/zairakai%2Fphp-packages%2Flaravel-twitch?logo=gitlab&label=Issues
[issues]: https://gitlab.com/zairakai/php-packages/laravel-twitch/-/issues
[php-badge]: https://img.shields.io/badge/php-8.4-blue?logo=php
[php]: https://www.php.net
[laravel-badge]: https://img.shields.io/badge/Laravel-12%20%7C%2013-red?logo=laravel
[laravel]: https://laravel.com
[phpstan-badge]: https://img.shields.io/badge/static%20analysis-phpstan-5B2C6F.svg?logo=php
[phpstan]: https://phpstan.org
[pint-badge]: https://img.shields.io/badge/code%20style-pint-22C55E.svg
[pint]: https://laravel.com/docs/pint
[ecosystem]: https://gitlab.com/zairakai
[docs]: https://laravel-twitch-8a8c1e.gitlab.io
[docs-badge]: https://img.shields.io/badge/docs-online-blue
[stats-card]: https://gitlab.com/zairakai/gitlab-profile/-/raw/main/assets/projects/laravel-twitch.svg
