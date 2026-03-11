<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Attributes\Test;
use ReflectionMethod;
use ReflectionProperty;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class TwitchApiServiceMethodsTest extends TestCase
{
    #[Test]
    public function it_caches_game_data(): void
    {
        Cache::flush();

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode(['access_token' => 'app-token', 'expires_in' => 3600])),
            new Response(200, [], json_encode(['data' => [['id' => '33214', 'name' => 'Fortnite']]])),
        ]);

        $twitchApiService = $this->makeService($mockHandler);
        $twitchApiService->getGame('33214');

        // Second call uses cache — mock has no more responses, so a real call would throw
        $cached = $twitchApiService->getGame('33214');

        $this->assertSame('33214', $cached['id']);
    }

    // ── getAppAccessToken ─────────────────────────────────────────────────────

    #[Test]
    public function it_fetches_and_caches_app_access_token(): void
    {
        Cache::flush();

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode(['access_token' => 'cached-token', 'expires_in' => 3600])),
        ]);

        $twitchApiService = $this->makeService($mockHandler);

        $token = $twitchApiService->getAppAccessToken();

        $this->assertSame('cached-token', $token);
        $this->assertSame('cached-token', Cache::get('twitch.app_access_token'));
    }

    // ── makeRawRequest ────────────────────────────────────────────────────────

    #[Test]
    public function it_makes_raw_get_request_and_returns_body_string(): void
    {
        $mockHandler = new MockHandler([
            new Response(200, [], 'BEGIN:VCALENDAR\r\nEND:VCALENDAR'),
        ]);

        $twitchApiService = $this->makeService($mockHandler);
        $twitchApiService->setAccessToken('test-token');

        /** @var string $result */
        $result = (new ReflectionMethod(TwitchApiService::class, 'makeRawRequest'))
            ->invoke($twitchApiService, 'GET', '/schedule/icalendar', ['broadcaster_id' => '123']);

        $this->assertStringContainsString('VCALENDAR', $result);
    }

    #[Test]
    public function it_makes_raw_post_request_with_json_body(): void
    {
        $mockHandler = new MockHandler([
            new Response(200, [], '{"ok":true}'),
        ]);

        $twitchApiService = $this->makeService($mockHandler);
        $twitchApiService->setAccessToken('test-token');

        /** @var string $result */
        $result = (new ReflectionMethod(TwitchApiService::class, 'makeRawRequest'))
            ->invoke($twitchApiService, 'POST', '/some/endpoint', ['key' => 'value']);

        $this->assertStringContainsString('ok', $result);
    }

    // ── getGame ───────────────────────────────────────────────────────────────

    #[Test]
    public function it_returns_game_data_from_api(): void
    {
        Cache::flush();

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode(['access_token' => 'app-token', 'expires_in' => 3600])),
            new Response(200, [], json_encode(['data' => [['id' => '33214', 'name' => 'Fortnite']]])),
        ]);

        $twitchApiService = $this->makeService($mockHandler);

        $game = $twitchApiService->getGame('33214');

        $this->assertIsArray($game);
        $this->assertSame('33214', $game['id']);
        $this->assertSame('Fortnite', $game['name']);
    }

    #[Test]
    public function it_returns_null_when_game_not_found(): void
    {
        Cache::flush();

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode(['access_token' => 'app-token', 'expires_in' => 3600])),
            new Response(200, [], json_encode(['data' => []])),
        ]);

        $twitchApiService = $this->makeService($mockHandler);

        $this->assertNull($twitchApiService->getGame('unknown-id'));
    }

    #[Test]
    public function it_returns_null_when_stream_is_offline(): void
    {
        Cache::flush();

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode(['access_token' => 'app-token', 'expires_in' => 3600])),
            new Response(200, [], json_encode(['data' => []])),
        ]);

        $twitchApiService = $this->makeService($mockHandler);

        $this->assertNull($twitchApiService->getStream('offline-user'));
    }

    // ── getStream ─────────────────────────────────────────────────────────────

    #[Test]
    public function it_returns_stream_data_from_api(): void
    {
        Cache::flush();

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode(['access_token' => 'app-token', 'expires_in' => 3600])),
            new Response(200, [], json_encode(['data' => [['id' => 'stream-1', 'user_id' => 'uid-1']]])),
        ]);

        $twitchApiService = $this->makeService($mockHandler);

        $stream = $twitchApiService->getStream('uid-1');

        $this->assertIsArray($stream);
        $this->assertSame('stream-1', $stream['id']);
    }

    // ── getUser ───────────────────────────────────────────────────────────────

    #[Test]
    public function it_returns_user_by_login_name(): void
    {
        Cache::flush();

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode(['access_token' => 'app-token', 'expires_in' => 3600])),
            new Response(200, [], json_encode(['data' => [['id' => '123', 'login' => 'ninja']]])),
        ]);

        $twitchApiService = $this->makeService($mockHandler);

        $user = $twitchApiService->getUser('ninja');

        $this->assertIsArray($user);
        $this->assertSame('ninja', $user['login']);
    }

    #[Test]
    public function it_returns_user_by_numeric_id(): void
    {
        Cache::flush();

        $mockHandler = new MockHandler([
            new Response(200, [], json_encode(['access_token' => 'app-token', 'expires_in' => 3600])),
            new Response(200, [], json_encode(['data' => [['id' => '123', 'login' => 'ninja']]])),
        ]);

        $twitchApiService = $this->makeService($mockHandler);

        $user = $twitchApiService->getUser(123);

        $this->assertIsArray($user);
        $this->assertSame('123', $user['id']);
    }

    // ── makeRequest: additional paths ─────────────────────────────────────────

    #[Test]
    public function it_sends_delete_request_with_query_params(): void
    {
        $mockHandler = new MockHandler([
            new Response(204, [], ''),
        ]);

        $twitchApiService = $this->makeService($mockHandler);
        $twitchApiService->setAccessToken('test-token');

        /** @var array<string, mixed> $result */
        $result = (new ReflectionMethod(TwitchApiService::class, 'makeRequest'))
            ->invoke($twitchApiService, 'DELETE', '/moderation/bans', [
                'broadcaster_id' => '123',
                'user_id'        => '456',
            ]);

        $this->assertSame([], $result);
    }

    #[Test]
    public function it_sends_post_request_with_json_body(): void
    {
        $mockHandler = new MockHandler([
            new Response(200, [], json_encode(['data' => [['id' => 'reward-1']]])),
        ]);

        $twitchApiService = $this->makeService($mockHandler);
        $twitchApiService->setAccessToken('test-token');

        /** @var array<string, mixed> $result */
        $result = (new ReflectionMethod(TwitchApiService::class, 'makeRequest'))
            ->invoke($twitchApiService, 'POST', '/channel_points/custom_rewards', [
                'broadcaster_id' => '123',
                'title'          => 'Test Reward',
                'cost'           => 100,
            ]);

        $this->assertArrayHasKey('data', $result);
    }

    // ── setAccessToken ────────────────────────────────────────────────────────

    #[Test]
    public function it_sets_access_token_and_returns_self(): void
    {
        $twitchApiService = new TwitchApiService('client-id', 'client-secret');

        $result = $twitchApiService->setAccessToken('my-token');

        $this->assertSame($twitchApiService, $result);

        $reflectionProperty = new ReflectionProperty(TwitchApiService::class, 'accessToken');

        $this->assertSame('my-token', $reflectionProperty->getValue($twitchApiService));
    }

    #[Test]
    public function it_throws_on_failed_api_request(): void
    {
        $mockHandler = new MockHandler([
            new Response(500, [], 'Internal Server Error'),
        ]);

        $twitchApiService = $this->makeService($mockHandler);
        $twitchApiService->setAccessToken('test-token');

        $this->expectException(RequestException::class);
        (new ReflectionMethod(TwitchApiService::class, 'makeRequest'))
            ->invoke($twitchApiService, 'GET', '/games', ['id' => '123']);
    }

    #[Test]
    public function it_throws_on_failed_raw_request(): void
    {
        $mockHandler = new MockHandler([
            new Response(500, [], 'Server Error'),
        ]);

        $twitchApiService = $this->makeService($mockHandler);
        $twitchApiService->setAccessToken('test-token');

        $this->expectException(RequestException::class);
        (new ReflectionMethod(TwitchApiService::class, 'makeRawRequest'))
            ->invoke($twitchApiService, 'GET', '/schedule/icalendar', []);
    }

    #[Test]
    public function it_throws_when_app_access_token_request_fails(): void
    {
        Cache::flush();

        $mockHandler = new MockHandler([
            new Response(500, [], 'Internal Server Error'),
        ]);

        $twitchApiService = $this->makeService($mockHandler);

        $this->expectException(RequestException::class);
        $twitchApiService->getAppAccessToken();
    }

    private function makeService(MockHandler $mockHandler): TwitchApiService
    {
        $twitchApiService = new TwitchApiService('test-client-id', 'test-client-secret');

        $client = new Client(['handler' => HandlerStack::create($mockHandler)]);

        $reflectionProperty = new ReflectionProperty(TwitchApiService::class, 'client');
        $reflectionProperty->setValue($twitchApiService, $client);

        return $twitchApiService;
    }
}
