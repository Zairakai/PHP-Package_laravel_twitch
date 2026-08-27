<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Chat\ChatSettings;
use Zairakai\LaravelTwitch\Dto\Chat\PinnedChatMessage;
use Zairakai\LaravelTwitch\Dto\Chat\SentMessage;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasChatMethodsTest extends TestCase
{
    // ── sendMessage ───────────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_chat_messages_endpoint(): void
    {
        $capturedParams = null;

        $service = new class('client-id', 'secret', $capturedParams) extends TwitchApiService
        {
            public function __construct(
                string $clientId,
                string $clientSecret,
                public mixed &$captured,
            ) {
                parent::__construct($clientId, $clientSecret);
            }

            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                $this->captured = ['method' => $method, 'endpoint' => $endpoint, 'params' => $params];

                return ['data' => [['message_id' => 'msg-1', 'is_sent' => true, 'drop_reason' => null]]];
            }
        };

        $service->sendMessage('1', '2', 'Hello world!');

        $this->assertSame('POST', $capturedParams['method']);
        $this->assertSame('/chat/messages', $capturedParams['endpoint']);
        $this->assertArrayNotHasKey('pin', $capturedParams['params']);
    }

    // ── getChatSettings ───────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_chat_settings_endpoint(): void
    {
        $capturedParams = null;

        $service = new class('client-id', 'secret', $capturedParams) extends TwitchApiService
        {
            public function __construct(
                string $clientId,
                string $clientSecret,
                public mixed &$captured,
            ) {
                parent::__construct($clientId, $clientSecret);
            }

            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                $this->captured = ['method' => $method, 'endpoint' => $endpoint, 'params' => $params];

                return [
                    'data' => [
                        [
                            'broadcaster_id'   => '1',
                            'emote_mode'       => false,
                            'follower_mode'    => false,
                            'slow_mode'        => false,
                            'subscriber_mode'  => false,
                            'unique_chat_mode' => false,
                        ],
                    ],
                ];
            }
        };

        $service->getChatSettings('1');

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/chat/settings', $capturedParams['endpoint']);
    }

    // ── pinMessage / updatePinnedMessage / unpinMessage / getPinnedMessage ──────

    #[Test]
    public function it_calls_the_pin_message_endpoint(): void
    {
        $capturedParams = null;

        $service = new class('client-id', 'secret', $capturedParams) extends TwitchApiService
        {
            public function __construct(
                string $clientId,
                string $clientSecret,
                public mixed &$captured,
            ) {
                parent::__construct($clientId, $clientSecret);
            }

            /**
             * @param array<string, mixed> $params
             */
            protected function makeQueryRequest(string $method, string $endpoint, array $params = []): array
            {
                $this->captured = ['method' => $method, 'endpoint' => $endpoint, 'params' => $params];

                return [];
            }
        };

        $service->pinMessage('1', '2', 'msg-1', 300);

        $this->assertSame('PUT', $capturedParams['method']);
        $this->assertSame('/chat/pins', $capturedParams['endpoint']);
        $this->assertSame(300, $capturedParams['params']['duration_seconds']);
    }

    #[Test]
    public function it_calls_the_unpin_message_endpoint(): void
    {
        $capturedParams = null;

        $service = new class('client-id', 'secret', $capturedParams) extends TwitchApiService
        {
            public function __construct(
                string $clientId,
                string $clientSecret,
                public mixed &$captured,
            ) {
                parent::__construct($clientId, $clientSecret);
            }

            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                $this->captured = ['method' => $method, 'endpoint' => $endpoint, 'params' => $params];

                return [];
            }
        };

        $service->unpinMessage('1', '2', 'msg-1');

        $this->assertSame('DELETE', $capturedParams['method']);
        $this->assertSame('/chat/pins', $capturedParams['endpoint']);
        $this->assertSame('msg-1', $capturedParams['params']['message_id']);
    }

    #[Test]
    public function it_calls_the_update_pinned_message_endpoint(): void
    {
        $capturedParams = null;

        $service = new class('client-id', 'secret', $capturedParams) extends TwitchApiService
        {
            public function __construct(
                string $clientId,
                string $clientSecret,
                public mixed &$captured,
            ) {
                parent::__construct($clientId, $clientSecret);
            }

            /**
             * @param array<string, mixed> $params
             */
            protected function makeQueryRequest(string $method, string $endpoint, array $params = []): array
            {
                $this->captured = ['method' => $method, 'endpoint' => $endpoint, 'params' => $params];

                return [];
            }
        };

        $service->updatePinnedMessage('1', '2', 'msg-1', 600);

        $this->assertSame('PATCH', $capturedParams['method']);
        $this->assertSame('/chat/pins', $capturedParams['endpoint']);
        $this->assertSame(600, $capturedParams['params']['duration_seconds']);
    }

    #[Test]
    public function it_exercises_chat_wrappers_for_collections_and_moderation_actions(): void
    {
        $service = new class('client-id', 'secret') extends TwitchApiService
        {
            /**
             * @var list<array{method: string, endpoint: string, params: array<string, mixed>}>
             */
            public array $calls = [];

            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                $this->calls[] = [
                    'method'   => $method,
                    'endpoint' => $endpoint,
                    'params'   => $params,
                ];

                return match ($endpoint) {
                    '/shared_chat/session' => [
                        'data' => [[
                            'session_id'             => 'session-1',
                            'host_broadcaster_id'    => 'b-1',
                            'host_broadcaster_login' => 'host',
                            'host_broadcaster_name'  => 'Host',
                            'participants'           => [],
                        ]],
                    ],
                    default => ['data' => [], 'pagination' => []],
                };
            }

            /**
             * @param array<string, mixed> $params
             */
            protected function makeQueryRequest(string $method, string $endpoint, array $params = []): array
            {
                return $this->makeRequest($method, $endpoint, $params);
            }
        };

        $service->clearChat('b-1', 'm-1');
        $service->deleteMessage('b-1', 'm-1', 'msg-1');
        $service->getChannelBadges('b-1');
        $service->getChannelEmotes('b-1');
        $service->getChatters('b-1', 'm-1', 5, 'cur-1');
        $service->getEmoteSets(['set-1']);
        $service->getGlobalBadges();
        $service->getGlobalEmotes();
        $service->getSharedChatSession('b-1');
        $service->getUserChatColor(['u-1']);
        $service->getUserEmotes('u-1', 'b-1', 'cur-2');
        $service->sendAnnouncement('b-1', 'm-1', 'hello');
        $service->sendShoutout('b-1', 'm-1', 'to-1');
        $service->updateUserChatColor('u-1', 'blue');

        $this->assertCount(14, $service->calls);
        $this->assertSame('/moderation/chat', $service->calls[0]['endpoint']);
        $this->assertSame('/shared_chat/session', $service->calls[8]['endpoint']);
        $this->assertSame('/chat/color', $service->calls[13]['endpoint']);
    }

    #[Test]
    public function it_omits_duration_seconds_from_pin_message_when_not_given(): void
    {
        $capturedParams = null;

        $service = new class('client-id', 'secret', $capturedParams) extends TwitchApiService
        {
            public function __construct(
                string $clientId,
                string $clientSecret,
                public mixed &$captured,
            ) {
                parent::__construct($clientId, $clientSecret);
            }

            /**
             * @param array<string, mixed> $params
             */
            protected function makeQueryRequest(string $method, string $endpoint, array $params = []): array
            {
                $this->captured = ['method' => $method, 'endpoint' => $endpoint, 'params' => $params];

                return [];
            }
        };

        $service->pinMessage('1', '2', 'msg-1');

        $this->assertArrayNotHasKey('duration_seconds', $capturedParams['params']);
    }

    #[Test]
    public function it_returns_a_chat_settings_dto(): void
    {
        $service = new class('client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                return [
                    'data' => [
                        [
                            'broadcaster_id'   => '1',
                            'emote_mode'       => false,
                            'follower_mode'    => false,
                            'slow_mode'        => false,
                            'subscriber_mode'  => false,
                            'unique_chat_mode' => false,
                        ],
                    ],
                ];
            }
        };

        $chatSettings = $service->getChatSettings('1');

        $this->assertInstanceOf(ChatSettings::class, $chatSettings);
        $this->assertSame('1', $chatSettings->broadcasterId);
        $this->assertFalse($chatSettings->emoteMode);
        $this->assertFalse($chatSettings->followerMode);
    }

    #[Test]
    public function it_returns_a_sent_message_dto(): void
    {
        $service = new class('client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                return ['data' => [['message_id' => 'msg-1', 'is_sent' => true, 'drop_reason' => null]]];
            }
        };

        $sentMessage = $service->sendMessage('1', '2', 'Hello world!');

        $this->assertInstanceOf(SentMessage::class, $sentMessage);
        $this->assertSame('msg-1', $sentMessage->messageId);
        $this->assertTrue($sentMessage->isSent);
    }

    #[Test]
    public function it_returns_null_when_no_message_is_pinned(): void
    {
        $service = new class('client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                return ['data' => []];
            }
        };

        $this->assertNull($service->getPinnedMessage('1', '2'));
    }

    #[Test]
    public function it_returns_the_pinned_chat_message_dto(): void
    {
        $service = new class('client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                return [
                    'data' => [
                        [
                            'message_id'           => 'abc-def-123-456',
                            'broadcaster_id'       => '197886470',
                            'sender_user_id'       => '12826',
                            'sender_user_login'    => 'twitch',
                            'sender_user_name'     => 'Twitch',
                            'pinned_by_user_id'    => '141981764',
                            'pinned_by_user_login' => 'twitchdev',
                            'pinned_by_user_name'  => 'TwitchDev',
                            'message'              => [
                                'text'      => 'Welcome!',
                                'fragments' => [
                                    ['type' => 'text', 'text' => 'Welcome!', 'cheermote' => null, 'emote' => null, 'mention' => null],
                                ],
                            ],
                            'starts_at'  => '2026-05-06T12:30:00Z',
                            'ends_at'    => '2026-05-06T12:35:00Z',
                            'updated_at' => '2026-05-06T12:30:00Z',
                        ],
                    ],
                ];
            }
        };

        $pinnedChatMessage = $service->getPinnedMessage('197886470', '141981764');

        $this->assertInstanceOf(PinnedChatMessage::class, $pinnedChatMessage);
        $this->assertSame('abc-def-123-456', $pinnedChatMessage->messageId);
        $this->assertSame('Welcome!', $pinnedChatMessage->message->text);
    }

    #[Test]
    public function it_sends_the_pin_flag_when_provided(): void
    {
        $capturedParams = null;

        $service = new class('client-id', 'secret', $capturedParams) extends TwitchApiService
        {
            public function __construct(
                string $clientId,
                string $clientSecret,
                public mixed &$captured,
            ) {
                parent::__construct($clientId, $clientSecret);
            }

            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                $this->captured = ['method' => $method, 'endpoint' => $endpoint, 'params' => $params];

                return ['data' => [['message_id' => 'msg-1', 'is_sent' => true, 'drop_reason' => null]]];
            }
        };

        $service->sendMessage('1', '2', 'Hello world!', pin: true);

        $this->assertTrue($capturedParams['params']['pin']);
    }
}
