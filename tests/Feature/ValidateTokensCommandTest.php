<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Feature;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Testing\PendingCommand;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Exceptions\TwitchApiException;
use Zairakai\LaravelTwitch\Models\TwitchUser;
use Zairakai\LaravelTwitch\Services\TwitchOAuthService;
use Zairakai\LaravelTwitch\Tests\TestCase;

/**
 * Twitch requires an app that keeps OAuth sessions to validate its tokens at startup and every hour.
 */
final class ValidateTokensCommandTest extends TestCase
{
    #[Test]
    public function it_dispatches_an_event_when_the_token_cannot_be_refreshed(): void
    {
        $twitchUser = $this->makeUser();
        $this->mockOAuth(
            validate: fn (): never => throw $this->unauthorized(),
            refresh: fn (): never => throw $this->unauthorized(),
        );
        Event::fake();

        $this->runCommand('1 invalid');

        self::assertFalse(TwitchUser::query()->findOrFail($twitchUser->id)->isTokenValid());
        Event::assertDispatched('twitch.token.invalid', static fn (string $name, array $payload): bool => $payload[0] instanceof TwitchUser);
    }

    #[Test]
    public function it_does_not_touch_a_token_when_twitch_or_the_network_fails(): void
    {
        $twitchUser = $this->makeUser();
        $this->mockOAuth(validate: static fn (): never => throw TwitchApiException::from(new ConnectException('network down', new Request('GET', 'validate'))));
        Event::fake();

        $this->runCommand('1 not checked');

        self::assertSame('access-1', TwitchUser::query()->findOrFail($twitchUser->id)->access_token);
        Event::assertNotDispatched('twitch.token.invalid');
    }

    #[Test]
    public function it_keeps_the_expiry_and_the_scopes_of_a_valid_token_up_to_date(): void
    {
        $twitchUser = $this->makeUser();
        $this->mockOAuth(validate: static fn (): array => [
            'expires_in' => 5000,
            'scopes'     => [
                'bits:read',
            ],
        ]);

        $this->runCommand('1 valid');

        $twitchUser->refresh();
        self::assertSame([
            'bits:read',
        ], $twitchUser->scopes);
        self::assertTrue($twitchUser->isTokenValid());
    }

    #[Test]
    public function it_refreshes_a_token_that_is_no_longer_valid(): void
    {
        $twitchUser = $this->makeUser();
        $this->mockOAuth(
            validate: fn (): never => throw $this->unauthorized(),
            refresh: static fn (): array => [
                'access_token'  => 'new-access',
                'refresh_token' => 'new-refresh',
                'expires_in'    => 3600,
                'scope'         => [
                    'bits:read',
                ],
            ],
        );
        Event::fake();

        $this->runCommand('1 refreshed');

        self::assertSame('new-access', TwitchUser::query()->findOrFail($twitchUser->id)->access_token);
        self::assertSame('new-refresh', TwitchUser::query()->findOrFail($twitchUser->id)->refresh_token);
        Event::assertNotDispatched('twitch.token.invalid');
    }

    private function makeUser(): TwitchUser
    {
        return TwitchUser::create([
            'twitch_id'     => '1',
            'login'         => 'someone',
            'display_name'  => 'Someone',
            'access_token'  => 'access-1',
            'refresh_token' => 'refresh-1',
            'expires_at'    => now()->addHour(),
        ]);
    }

    /**
     * @param (callable(): mixed)|null $validate
     * @param (callable(): mixed)|null $refresh
     */
    private function mockOAuth(?callable $validate = null, ?callable $refresh = null): void
    {
        $oauth = self::createStub(TwitchOAuthService::class);
        $oauth->method('validateToken')->willReturnCallback($validate ?? static fn (): array => []);
        $oauth->method('refreshToken')->willReturnCallback($refresh ?? static fn (): array => []);

        $this->app?->instance(TwitchOAuthService::class, $oauth);
    }

    private function runCommand(string $expected): void
    {
        $pending = $this->artisan('twitch:validate-tokens');
        self::assertInstanceOf(PendingCommand::class, $pending);
        $pending->expectsOutputToContain($expected)->assertSuccessful();
    }

    private function unauthorized(): TwitchApiException
    {
        return TwitchApiException::from(new ClientException(
            'Unauthorized',
            new Request('GET', 'validate'),
            new Response(401),
        ));
    }
}
