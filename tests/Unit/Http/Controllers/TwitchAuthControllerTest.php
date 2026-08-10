<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Session\ArraySessionHandler;
use Illuminate\Session\Store as SessionStore;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelSubscribeEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\GenericEventSubEvent;
use Zairakai\LaravelTwitch\Dto\Users\User as TwitchUserDto;
use Zairakai\LaravelTwitch\Http\Controllers\TwitchAuthController;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Services\TwitchOAuthService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class TwitchAuthControllerTest extends TestCase
{
    private TwitchAuthController $twitchAuthController;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var TwitchOAuthService $oauth */
        $oauth = $this->createStub(TwitchOAuthService::class);

        /** @var TwitchApiService $api */
        $api = $this->createStub(TwitchApiService::class);

        $this->twitchAuthController = new TwitchAuthController($oauth, $api);
    }

    // ── Webhook: valid signature ──────────────────────────────────────────────

    #[Test]
    public function it_accepts_webhook_with_valid_twitch_hmac(): void
    {
        $secret = 'my-secret';
        // Type intentionally does not exist in Twitch's catalog - this test is about
        // signature validation, not typed-DTO resolution - falls back to
        // GenericEventSubEvent regardless of the (empty) event payload.
        $body      = '{"subscription":{"type":"channel.a_type_twitch_has_not_invented_yet"},"event":{}}';
        $messageId = 'msg-001';
        $timestamp = '2024-01-01T00:00:00Z';

        config(['twitch.eventsub.webhook_secret' => $secret]);

        // Correct Twitch format: HMAC over message-id + timestamp + body
        $sig = 'sha256=' . hash_hmac('sha256', $messageId . $timestamp . $body, $secret);

        $request = Request::create('/twitch/webhook', 'POST', [], [], [], [
            'HTTP_TWITCH_EVENTSUB_MESSAGE_ID'        => $messageId,
            'HTTP_TWITCH_EVENTSUB_MESSAGE_TIMESTAMP' => $timestamp,
            'HTTP_TWITCH_EVENTSUB_MESSAGE_TYPE'      => 'notification',
            'HTTP_TWITCH_EVENTSUB_MESSAGE_SIGNATURE' => $sig,
            'CONTENT_TYPE'                           => 'application/json',
        ], $body);

        $jsonResponse = $this->twitchAuthController->webhook($request);

        $this->assertSame(200, $jsonResponse->getStatusCode());
        $data = json_decode((string) $jsonResponse->getContent(), true);
        $this->assertSame('ok', $data['status']);
    }

    // ── Webhook: handleEventSubNotification branches ──────────────────────────

    #[Test]
    public function it_dispatches_a_generic_typed_fallback_for_unmapped_notification_type(): void
    {
        Event::fake();

        $jsonResponse = $this->makeNotificationResponse('channel.unknown');

        $this->assertSame(200, $jsonResponse->getStatusCode());

        // String-based events dispatch the event name + raw payload array to the
        // assertion callback (not the DTO directly) - see Illuminate\Support\Testing\Fakes\EventFake.
        Event::assertDispatched(
            'twitch.channel.unknown',
            /** @param array{0: GenericEventSubEvent} $payload */
            fn (string $name, array $payload): bool => 'channel.unknown' === $payload[0]->type,
        );
    }

    #[Test]
    public function it_dispatches_a_typed_dto_on_channel_subscribe_notification(): void
    {
        Event::fake();

        $jsonResponse = $this->makeNotificationResponse('channel.subscribe', [
            'user_id'                => '111',
            'user_login'             => 'subscriber',
            'user_name'              => 'Subscriber',
            'broadcaster_user_id'    => '12345',
            'broadcaster_user_login' => 'zairakai',
            'broadcaster_user_name'  => 'Zairakai',
            'tier'                   => '1000',
            'is_gift'                => false,
        ]);

        $this->assertSame(200, $jsonResponse->getStatusCode());
        Event::assertDispatched(
            'twitch.channel.subscribe',
            /** @param array{0: ChannelSubscribeEvent} $payload */
            fn (string $name, array $payload): bool => '1000' === $payload[0]->tier,
        );
    }

    #[Test]
    public function it_dispatches_stream_offline_event_on_notification(): void
    {
        $jsonResponse = $this->makeNotificationResponse('stream.offline', [
            'broadcaster_user_id'    => '12345',
            'broadcaster_user_login' => 'zairakai',
            'broadcaster_user_name'  => 'Zairakai',
        ]);

        $this->assertSame(200, $jsonResponse->getStatusCode());
    }

    #[Test]
    public function it_dispatches_stream_online_event_on_notification(): void
    {
        $jsonResponse = $this->makeNotificationResponse('stream.online', [
            'id'                     => 'stream-1',
            'broadcaster_user_id'    => '12345',
            'broadcaster_user_login' => 'zairakai',
            'broadcaster_user_name'  => 'Zairakai',
            'type'                   => 'live',
            'started_at'             => '2024-01-01T00:00:00Z',
        ]);

        $this->assertSame(200, $jsonResponse->getStatusCode());
    }

    #[Test]
    public function it_redirects_home_with_error_on_exception_during_callback(): void
    {
        $oauth = $this->createMock(TwitchOAuthService::class);
        $oauth->expects($this->once())
            ->method('getAccessToken')
            ->willThrowException(new Exception('API unavailable'));

        $api                  = $this->createStub(TwitchApiService::class);
        $twitchAuthController = new TwitchAuthController($oauth, $api);

        $store = $this->makeSession();
        $store->put('twitch_oauth_state', 'valid-state');

        $request = Request::create('/twitch/auth/callback', 'GET', [
            'state' => 'valid-state',
            'code'  => 'auth-code',
        ]);
        $request->setLaravelSession($store);

        $redirectResponse = $twitchAuthController->callback($request);

        $this->assertSame(302, $redirectResponse->getStatusCode());
    }

    #[Test]
    public function it_redirects_home_with_error_when_user_info_is_unavailable(): void
    {
        $oauth = $this->createMock(TwitchOAuthService::class);
        $oauth->expects($this->once())
            ->method('getAccessToken')
            ->willReturn([
                'access_token'  => 'tok-abc',
                'refresh_token' => 'ref-abc',
                'expires_in'    => 14400,
                'scope'         => ['user:read:email'],
                'token_type'    => 'bearer',
            ]);

        $api = $this->createMock(TwitchApiService::class);
        $api->expects($this->once())->method('setAccessToken')->willReturnSelf();
        $api->expects($this->once())->method('getAuthenticatedUser')->willReturn(null);

        $twitchAuthController = new TwitchAuthController($oauth, $api);

        $store = $this->makeSession();
        $store->put('twitch_oauth_state', 'valid-state');

        $request = Request::create('/twitch/auth/callback', 'GET', [
            'state' => 'valid-state',
            'code'  => 'auth-code',
        ]);
        $request->setLaravelSession($store);

        $redirectResponse = $twitchAuthController->callback($request);

        $this->assertSame(302, $redirectResponse->getStatusCode());
    }

    // ── redirect ──────────────────────────────────────────────────────────────

    #[Test]
    public function it_redirects_to_twitch_authorization_url(): void
    {
        $oauth = $this->createMock(TwitchOAuthService::class);
        $oauth->expects($this->once())
            ->method('getAuthorizationUrl')
            ->willReturn('https://id.twitch.tv/oauth2/authorize?client_id=test&response_type=code&state=xyz');

        $api                  = $this->createStub(TwitchApiService::class);
        $twitchAuthController = new TwitchAuthController($oauth, $api);

        $store   = $this->makeSession();
        $request = Request::create('/twitch/auth', 'GET');
        $request->setLaravelSession($store);

        $redirectResponse = $twitchAuthController->redirect($request);

        $this->assertSame(302, $redirectResponse->getStatusCode());
        $this->assertStringContainsString('id.twitch.tv', $redirectResponse->getTargetUrl());
        $this->assertNotEmpty($store->get('twitch_oauth_state'));
    }

    #[Test]
    public function it_rejects_callback_when_code_is_missing(): void
    {
        $store = $this->makeSession();
        $store->put('twitch_oauth_state', 'valid-state');

        $request = Request::create('/twitch/auth/callback', 'GET', ['state' => 'valid-state']);
        $request->setLaravelSession($store);

        $redirectResponse = $this->twitchAuthController->callback($request);

        $this->assertSame(302, $redirectResponse->getStatusCode());
    }

    // ── callback ──────────────────────────────────────────────────────────────

    #[Test]
    public function it_rejects_callback_when_state_is_mismatched(): void
    {
        $store = $this->makeSession();
        $store->put('twitch_oauth_state', 'expected-state');

        $request = Request::create('/twitch/auth/callback', 'GET', [
            'state' => 'wrong-state',
            'code'  => 'some-code',
        ]);
        $request->setLaravelSession($store);

        $redirectResponse = $this->twitchAuthController->callback($request);

        $this->assertSame(302, $redirectResponse->getStatusCode());
    }

    #[Test]
    public function it_rejects_challenge_when_signature_is_invalid(): void
    {
        config(['twitch.eventsub.webhook_secret' => 'my-secret']);

        $body = '{"challenge":"should-not-reply","subscription":{"type":"channel.follow"}}';

        $request = Request::create('/twitch/webhook', 'POST', [], [], [], [
            'HTTP_TWITCH_EVENTSUB_MESSAGE_ID'        => 'msg-003',
            'HTTP_TWITCH_EVENTSUB_MESSAGE_TIMESTAMP' => '2024-01-01T00:00:00Z',
            'HTTP_TWITCH_EVENTSUB_MESSAGE_TYPE'      => 'webhook_callback_verification',
            'HTTP_TWITCH_EVENTSUB_MESSAGE_SIGNATURE' => 'sha256=badsig',
            'CONTENT_TYPE'                           => 'application/json',
        ], $body);

        $jsonResponse = $this->twitchAuthController->webhook($request);

        $this->assertSame(400, $jsonResponse->getStatusCode());
    }

    #[Test]
    public function it_rejects_webhook_when_message_id_header_is_missing(): void
    {
        $secret    = 'my-secret';
        $body      = '{"event":"test"}';
        $timestamp = '2024-01-01T00:00:00Z';

        config(['twitch.eventsub.webhook_secret' => $secret]);

        // Signature computed without message ID (old incorrect format)
        $sig = 'sha256=' . hash_hmac('sha256', $timestamp . $body, $secret);

        $request = Request::create('/twitch/webhook', 'POST', [], [], [], [
            // message-id header intentionally absent
            'HTTP_TWITCH_EVENTSUB_MESSAGE_TIMESTAMP' => $timestamp,
            'HTTP_TWITCH_EVENTSUB_MESSAGE_TYPE'      => 'notification',
            'HTTP_TWITCH_EVENTSUB_MESSAGE_SIGNATURE' => $sig,
        ], $body);

        $jsonResponse = $this->twitchAuthController->webhook($request);

        $this->assertSame(400, $jsonResponse->getStatusCode());
    }

    // ── Webhook: no secret configured ────────────────────────────────────────

    #[Test]
    public function it_rejects_webhook_when_no_secret_is_configured(): void
    {
        config(['twitch.eventsub.webhook_secret' => '']);

        $body      = '{"event":"test"}';
        $messageId = 'msg-001';
        $timestamp = '2024-01-01T00:00:00Z';
        $sig       = 'sha256=' . hash_hmac('sha256', $messageId . $timestamp . $body, 'some-secret');

        $request = Request::create('/twitch/webhook', 'POST', [], [], [], [
            'HTTP_TWITCH_EVENTSUB_MESSAGE_ID'        => $messageId,
            'HTTP_TWITCH_EVENTSUB_MESSAGE_TIMESTAMP' => $timestamp,
            'HTTP_TWITCH_EVENTSUB_MESSAGE_TYPE'      => 'notification',
            'HTTP_TWITCH_EVENTSUB_MESSAGE_SIGNATURE' => $sig,
        ], $body);

        $jsonResponse = $this->twitchAuthController->webhook($request);

        $this->assertSame(400, $jsonResponse->getStatusCode());
    }

    #[Test]
    public function it_rejects_webhook_when_old_hmac_format_is_used_without_message_id(): void
    {
        $secret    = 'my-secret';
        $body      = '{"event":"test"}';
        $messageId = 'msg-001';
        $timestamp = '2024-01-01T00:00:00Z';

        config(['twitch.eventsub.webhook_secret' => $secret]);

        // Old (incorrect) format: HMAC over timestamp + body only, missing message ID
        $wrongSig = 'sha256=' . hash_hmac('sha256', $timestamp . $body, $secret);

        $request = Request::create('/twitch/webhook', 'POST', [], [], [], [
            'HTTP_TWITCH_EVENTSUB_MESSAGE_ID'        => $messageId,
            'HTTP_TWITCH_EVENTSUB_MESSAGE_TIMESTAMP' => $timestamp,
            'HTTP_TWITCH_EVENTSUB_MESSAGE_TYPE'      => 'notification',
            'HTTP_TWITCH_EVENTSUB_MESSAGE_SIGNATURE' => $wrongSig,
        ], $body);

        $jsonResponse = $this->twitchAuthController->webhook($request);

        $this->assertSame(400, $jsonResponse->getStatusCode());
    }

    // ── Webhook: missing headers ──────────────────────────────────────────────

    #[Test]
    public function it_rejects_webhook_when_signature_header_is_missing(): void
    {
        config(['twitch.eventsub.webhook_secret' => 'my-secret']);

        $request = Request::create('/twitch/webhook', 'POST', [], [], [], [
            'HTTP_TWITCH_EVENTSUB_MESSAGE_ID'        => 'msg-001',
            'HTTP_TWITCH_EVENTSUB_MESSAGE_TIMESTAMP' => '2024-01-01T00:00:00Z',
            'HTTP_TWITCH_EVENTSUB_MESSAGE_TYPE'      => 'notification',
            // signature intentionally absent
        ], '{"event":"test"}');

        $jsonResponse = $this->twitchAuthController->webhook($request);

        $this->assertSame(400, $jsonResponse->getStatusCode());
    }

    // ── Webhook: wrong signature ──────────────────────────────────────────────

    #[Test]
    public function it_rejects_webhook_with_incorrect_hmac(): void
    {
        config(['twitch.eventsub.webhook_secret' => 'my-secret']);

        $request = Request::create('/twitch/webhook', 'POST', [], [], [], [
            'HTTP_TWITCH_EVENTSUB_MESSAGE_ID'        => 'msg-001',
            'HTTP_TWITCH_EVENTSUB_MESSAGE_TIMESTAMP' => '2024-01-01T00:00:00Z',
            'HTTP_TWITCH_EVENTSUB_MESSAGE_TYPE'      => 'notification',
            'HTTP_TWITCH_EVENTSUB_MESSAGE_SIGNATURE' => 'sha256=totallywrongsignature',
        ], '{"event":"test"}');

        $jsonResponse = $this->twitchAuthController->webhook($request);

        $this->assertSame(400, $jsonResponse->getStatusCode());
    }

    // ── Webhook: challenge verification ──────────────────────────────────────

    #[Test]
    public function it_responds_to_webhook_challenge_with_the_challenge_value(): void
    {
        $secret    = 'my-secret';
        $body      = '{"challenge":"verify-me-123","subscription":{"type":"channel.follow"}}';
        $messageId = 'msg-002';
        $timestamp = '2024-01-01T00:00:00Z';

        config(['twitch.eventsub.webhook_secret' => $secret]);

        $sig = 'sha256=' . hash_hmac('sha256', $messageId . $timestamp . $body, $secret);

        $request = Request::create('/twitch/webhook', 'POST', [], [], [], [
            'HTTP_TWITCH_EVENTSUB_MESSAGE_ID'        => $messageId,
            'HTTP_TWITCH_EVENTSUB_MESSAGE_TIMESTAMP' => $timestamp,
            'HTTP_TWITCH_EVENTSUB_MESSAGE_TYPE'      => 'webhook_callback_verification',
            'HTTP_TWITCH_EVENTSUB_MESSAGE_SIGNATURE' => $sig,
            'CONTENT_TYPE'                           => 'application/json',
        ], $body);

        $jsonResponse = $this->twitchAuthController->webhook($request);

        $this->assertSame(200, $jsonResponse->getStatusCode());
        $data = json_decode((string) $jsonResponse->getContent(), true);
        $this->assertSame('verify-me-123', $data['challenge']);
    }

    #[Test]
    public function it_stores_twitch_user_and_redirects_home_on_successful_callback(): void
    {
        $user = new TwitchUserDto(
            id: '123456',
            login: 'ninja',
            displayName: 'Ninja',
            type: '',
            broadcasterType: 'partner',
            description: 'Famous streamer',
            profileImageUrl: 'https://example.com/avatar.jpg',
            offlineImageUrl: '',
            viewCount: 1000000,
        );

        $oauth = $this->createMock(TwitchOAuthService::class);
        $oauth->expects($this->once())
            ->method('getAccessToken')
            ->willReturn([
                'access_token'  => 'tok-abc',
                'refresh_token' => 'ref-abc',
                'expires_in'    => 14400,
                'scope'         => ['user:read:email'],
                'token_type'    => 'bearer',
            ]);

        $api = $this->createMock(TwitchApiService::class);
        $api->expects($this->once())->method('setAccessToken')->willReturnSelf();
        $api->expects($this->once())->method('getAuthenticatedUser')->willReturn($user);

        $twitchAuthController = new TwitchAuthController($oauth, $api);

        $store = $this->makeSession();
        $store->put('twitch_oauth_state', 'valid-state');

        $request = Request::create('/twitch/auth/callback', 'GET', [
            'state' => 'valid-state',
            'code'  => 'auth-code',
        ]);
        $request->setLaravelSession($store);

        $redirectResponse = $twitchAuthController->callback($request);

        $this->assertSame(302, $redirectResponse->getStatusCode());
        $this->assertDatabaseHas('twitch_users', ['twitch_id' => '123456', 'login' => 'ninja']);
    }

    protected function defineRoutes($router): void
    {
        $router->get('/', static fn (): string => 'home')->name('home');
    }

    /**
     * @param array<string, mixed> $eventData
     */
    private function makeNotificationResponse(string $eventType, array $eventData = []): JsonResponse
    {
        $secret    = 'my-secret';
        $body      = json_encode(['subscription' => ['type' => $eventType], 'event' => $eventData]);
        $messageId = 'msg-' . str_replace('.', '-', $eventType);
        $timestamp = '2024-01-01T00:00:00Z';

        config(['twitch.eventsub.webhook_secret' => $secret]);

        $sig = 'sha256=' . hash_hmac('sha256', $messageId . $timestamp . $body, $secret);

        $request = Request::create('/twitch/webhook', 'POST', [], [], [], [
            'HTTP_TWITCH_EVENTSUB_MESSAGE_ID'        => $messageId,
            'HTTP_TWITCH_EVENTSUB_MESSAGE_TIMESTAMP' => $timestamp,
            'HTTP_TWITCH_EVENTSUB_MESSAGE_TYPE'      => 'notification',
            'HTTP_TWITCH_EVENTSUB_MESSAGE_SIGNATURE' => $sig,
            'CONTENT_TYPE'                           => 'application/json',
        ], $body);

        return $this->twitchAuthController->webhook($request);
    }

    private function makeSession(): SessionStore
    {
        $store = new SessionStore('test', new ArraySessionHandler(60));
        $store->start();

        return $store;
    }
}
