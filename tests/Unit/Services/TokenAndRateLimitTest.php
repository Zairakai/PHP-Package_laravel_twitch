<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Sleep;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\RequestInterface;
use ReflectionProperty;
use Zairakai\LaravelTwitch\Exceptions\TwitchApiException;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

/**
 * What the client does when Twitch answers 401 (token no longer valid) or 429 (rate limit).
 */
final class TokenAndRateLimitTest extends TestCase
{
    /**
     * @var list<RequestInterface>
     */
    private array $requests = [];

    #[Test]
    public function it_asks_the_refresher_for_a_new_user_token_after_a_401(): void
    {
        $calls   = 0;
        $service = $this->makeService(
            new Response(
                401,
                [],
                '{"status":401,"message":"Invalid OAuth token"}',
            ),
            new Response(
                200,
                [],
                '{"data":[]}',
            ),
        );
        $service->setAccessToken('old-user-token');
        $service->setTokenRefresher(static function () use (&$calls): string {
            $calls++;

            return 'new-user-token';
        });

        $service->getTopGames(5);

        self::assertSame(1, $calls);
        self::assertCount(2, $this->requests);
        self::assertSame('Bearer old-user-token', $this->requests[0]->getHeaderLine('Authorization'));
        self::assertSame('Bearer new-user-token', $this->requests[1]->getHeaderLine('Authorization'));
    }

    #[Test]
    public function it_caches_the_public_calls_that_were_not_cached(): void
    {
        Cache::flush();
        $answer  = '{"data":[{"id":"1","name":"Game","box_art_url":"u","igdb_id":"1"}],"pagination":{}}';
        $service = $this->makeService(new Response(
            200,
            [],
            $answer,
        ), new Response(
            200,
            [],
            $answer,
        ));
        $service->setAccessToken('user-token');

        $service->getTopGames(5);
        $service->getTopGames(5);
        self::assertCount(1, $this->requests);

        // Another page is another answer
        $service->getTopGames(10);
        self::assertCount(2, $this->requests);
    }

    #[Test]
    public function it_does_not_cache_when_the_cache_is_turned_off(): void
    {
        Cache::flush();
        config([
            'twitch.cache.enabled' => false,
        ]);
        $answer  = '{"data":[{"id":"7","name":"Game"}]}';
        $service = $this->makeService(new Response(
            200,
            [],
            $answer,
        ), new Response(
            200,
            [],
            $answer,
        ));
        $service->setAccessToken('user-token');

        $service->getGame('7');
        $service->getGame('7');

        self::assertCount(2, $this->requests);
    }

    #[Test]
    public function it_does_not_wait_when_the_rate_limit_is_off(): void
    {
        Cache::flush();
        Sleep::fake();
        config([
            'twitch.rate_limit.enabled'     => false,
            'twitch.rate_limit.burst_limit' => 1,
        ]);
        $service = $this->makeService(
            new Response(
                200,
                [],
                '{"data":[]}',
            ),
            new Response(
                200,
                [],
                '{"data":[]}',
            ),
            new Response(
                200,
                [],
                '{"data":[]}',
            ),
        );
        $service->setAccessToken('user-token');

        $service->getStreams();
        $service->getStreams();
        $service->getStreams();

        Sleep::assertNeverSlept();
    }

    #[Test]
    public function it_gets_a_new_app_token_after_a_401_and_sends_the_request_again(): void
    {
        Cache::put(
            'twitch.app_access_token',
            'stale-token',
            3600,
        );

        $service = $this->makeService(
            new Response(
                401,
                [],
                '{"error":"Unauthorized","status":401,"message":"Invalid OAuth token"}',
            ),
            new Response(
                200,
                [],
                '{"access_token":"fresh-token","expires_in":5000000}',
            ),
            new Response(
                200,
                [],
                '{"data":[]}',
            ),
        );

        $service->getTopGames(5);

        self::assertCount(3, $this->requests);
        self::assertSame('Bearer stale-token', $this->requests[0]->getHeaderLine('Authorization'));
        self::assertSame('Bearer fresh-token', $this->requests[2]->getHeaderLine('Authorization'));
        self::assertSame('fresh-token', Cache::get('twitch.app_access_token'));
    }

    #[Test]
    public function it_gives_an_empty_schedule_when_nothing_is_planned(): void
    {
        $service = $this->makeService(
            new Response(
                404,
                [],
                '{"error":"Not Found","status":404,"message":"segments were not found"}',
            ),
        );
        $service->setAccessToken('user-token');

        $schedule = $service->getSchedule('123');

        self::assertSame('123', $schedule->broadcasterId);
        self::assertCount(0, $schedule->segments);
        self::assertNull($schedule->vacation);
    }

    #[Test]
    public function it_gives_up_when_the_refresher_has_no_new_token(): void
    {
        $service = $this->makeService(new Response(
            401,
            [],
            '{"status":401}',
        ));
        $service->setAccessToken('old-user-token');
        $service->setTokenRefresher(static fn (): ?string => null);

        $this->expectException(TwitchApiException::class);

        try {
            $service->getTopGames(5);
        }
        finally {
            self::assertCount(1, $this->requests);
        }
    }

    #[Test]
    public function it_refuses_an_eventsub_subscription_without_callback_or_secret(): void
    {
        config([
            'twitch.eventsub.webhook_callback_url' => null,
            'twitch.eventsub.webhook_secret'       => null,
        ]);

        $this->expectException(InvalidArgumentException::class);

        $this->makeService()->createEventSubSubscription('stream.online', [
            'broadcaster_user_id' => '1',
        ]);
    }

    #[Test]
    public function it_retries_a_user_token_only_once_after_a_401(): void
    {
        $service = $this->makeService(
            new Response(
                401,
                [],
                '{"status":401}',
            ),
            new Response(
                401,
                [],
                '{"status":401}',
            ),
            new Response(
                200,
                [],
                '{"data":[]}',
            ),
        );
        $service->setAccessToken('old-user-token');
        $service->setTokenRefresher(static fn (): string => 'new-user-token');

        $this->expectException(TwitchApiException::class);

        try {
            $service->getTopGames(5);
        }
        finally {
            self::assertCount(2, $this->requests);
        }
    }

    #[Test]
    public function it_still_throws_the_other_errors_of_the_schedule(): void
    {
        $service = $this->makeService(
            new Response(
                400,
                [],
                '{"status":400,"message":"The parameter \"broadcaster_id\" was malformed: value must be a positive numeric"}',
            ),
        );
        $service->setAccessToken('user-token');

        try {
            $service->getSchedule('0');
            self::fail('A 400 is an error');
        }
        catch (TwitchApiException $twitchApiException) {
            self::assertSame('malformed_parameter', $twitchApiException->errorCode());
            self::assertSame('broadcaster_id', $twitchApiException->error->context['parameter']);
        }
    }

    #[Test]
    public function it_stops_retrying_after_the_configured_number_of_times(): void
    {
        Sleep::fake();
        config([
            'twitch.api.retry.times' => 2,
            'twitch.api.retry.sleep' => 100,
        ]);

        $service = $this->makeService(
            new Response(
                429,
                [],
                '{"status":429}',
            ),
            new Response(
                429,
                [],
                '{"status":429}',
            ),
            new Response(
                429,
                [],
                '{"status":429}',
            ),
            new Response(
                200,
                [],
                '{"data":[]}',
            ),
        );
        $service->setAccessToken('user-token');

        try {
            $service->getTopGames(5);
            self::fail('A 429 was expected.');
        }
        catch (TwitchApiException) {
            self::assertCount(3, $this->requests);
            Sleep::assertSleptTimes(2);
        }
    }

    #[Test]
    public function it_takes_the_callback_and_the_secret_of_the_eventsub_subscription_from_the_configuration(): void
    {
        config([
            'twitch.eventsub.webhook_callback_url' => 'https://app.example.com/twitch/webhook',
            'twitch.eventsub.webhook_secret'       => 'a-secret-of-ten-chars',
        ]);
        $service = $this->makeService(
            new Response(
                202,
                [],
                '{"data":[{"id":"s1","status":"webhook_callback_verification_pending","type":"stream.online","version":"1","condition":{"broadcaster_user_id":"1"},"created_at":"2026-11-20T10:00:00Z","transport":{"method":"webhook","callback":"https://app.example.com/twitch/webhook"},"cost":1}],"total":1,"total_cost":1,"max_total_cost":10000}',
            ),
        );

        $service->setAccessToken('app-token');
        $service->createEventSubSubscription('stream.online', [
            'broadcaster_user_id' => '1',
        ]);

        $sent = json_decode((string) $this->requests[0]->getBody(), true);
        self::assertIsArray($sent);
        self::assertIsArray($sent['transport']);
        self::assertSame('https://app.example.com/twitch/webhook', $sent['transport']['callback']);
        self::assertSame('a-secret-of-ten-chars', $sent['transport']['secret']);
    }

    #[Test]
    public function it_throws_a_401_for_a_user_token_when_there_is_no_refresher(): void
    {
        $service = $this->makeService(new Response(
            401,
            [],
            '{"status":401,"message":"Invalid OAuth token"}',
        ));
        $service->setAccessToken('old-user-token');

        try {
            $service->getTopGames(5);
            self::fail('A 401 was expected.');
        }
        catch (TwitchApiException $twitchApiException) {
            self::assertSame(401, $twitchApiException->status());
        }

        self::assertCount(1, $this->requests);
    }

    #[Test]
    public function it_throws_the_429_when_the_wait_would_be_too_long(): void
    {
        Sleep::fake();

        $service = $this->makeService(new Response(429, [
            'Ratelimit-Reset' => (string) (time() + 60),
        ], '{"status":429}'));
        $service->setAccessToken('user-token');

        try {
            $service->getTopGames(5);
            self::fail('A 429 was expected.');
        }
        catch (TwitchApiException $twitchApiException) {
            self::assertSame(429, $twitchApiException->status());
        }

        Sleep::assertNeverSlept();
        self::assertCount(1, $this->requests);
    }

    #[Test]
    public function it_waits_for_the_rate_limit_to_reset_then_sends_the_request_again(): void
    {
        Sleep::fake();

        $service = $this->makeService(
            new Response(429, [
                'Ratelimit-Reset' => (string) (time() + 2),
            ], '{"status":429,"message":"Too Many Requests"}'),
            new Response(
                200,
                [],
                '{"data":[]}',
            ),
        );
        $service->setAccessToken('user-token');

        $service->getTopGames(5);

        self::assertCount(2, $this->requests);
        Sleep::assertSleptTimes(1);
    }

    #[Test]
    public function it_waits_the_configured_time_when_twitch_gives_no_reset_time(): void
    {
        Sleep::fake();
        config([
            'twitch.api.retry.sleep' => 250,
        ]);

        $service = $this->makeService(
            new Response(
                429,
                [],
                '{"status":429}',
            ),
            new Response(
                200,
                [],
                '{"data":[]}',
            ),
        );
        $service->setAccessToken('user-token');

        $service->getTopGames(5);

        Sleep::assertSequence([
            Sleep::for(250)->milliseconds(),
        ]);
    }

    #[Test]
    public function it_waits_when_the_bucket_of_calls_is_empty(): void
    {
        Cache::flush();
        Date::setTestNow(now());
        Sleep::fake(syncWithCarbon: true);
        config([
            'twitch.rate_limit.enabled'             => true,
            'twitch.rate_limit.requests_per_minute' => 60,
            'twitch.rate_limit.burst_limit'         => 2,
        ]);
        $answer  = '{"data":[]}';
        $service = $this->makeService(
            new Response(
                200,
                [],
                $answer,
            ),
            new Response(
                200,
                [],
                $answer,
            ),
            new Response(
                200,
                [],
                $answer,
            ),
        );
        $service->setAccessToken('user-token');

        $service->getStreams();
        $service->getStreams();
        Sleep::assertNeverSlept();

        // The third call is over the burst: it waits for a token (one per second at 60 a minute)
        $service->getStreams();
        Sleep::assertSleptTimes(1);
        self::assertCount(3, $this->requests);

        Date::setTestNow();
    }

    #[Test]
    public function the_default_configuration_matches_the_routes_and_asks_the_scopes_that_the_methods_need(): void
    {
        $config = require dirname(__DIR__, 3) . '/config/twitch.php';
        self::assertIsArray($config);

        self::assertSame('/twitch/auth/callback', $config['redirect_uri']);
        self::assertIsArray($config['scopes']);

        foreach ([
            'user:read:subscriptions',
            'channel:manage:videos',
            'channel:manage:clips',
            'editor:manage:clips',
            'moderator:read:chat_messages',
        ] as $scope) {
            self::assertContains($scope, $config['scopes']);
        }
    }

    private function makeService(Response ...$responses): TwitchApiService
    {
        $this->requests = [];
        $handlerStack   = HandlerStack::create(new MockHandler($responses));
        $handlerStack->push(Middleware::mapRequest(function (RequestInterface $request): RequestInterface {
            $this->requests[] = $request;

            return $request;
        }));

        $twitchApiService = new TwitchApiService('test-client-id', 'test-client-secret');

        new ReflectionProperty(TwitchApiService::class, 'client')->setValue(
            $twitchApiService,
            new Client([
                'base_uri' => 'https://api.twitch.tv/helix/',
                'handler'  => $handlerStack,
            ]),
        );

        return $twitchApiService;
    }
}
