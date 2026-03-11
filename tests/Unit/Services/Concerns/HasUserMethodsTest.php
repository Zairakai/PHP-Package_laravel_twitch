<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Users\User;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasUserMethodsTest extends TestCase
{
    #[Test]
    public function it_calls_users_endpoint_with_no_params(): void
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

                return ['data' => []];
            }
        };

        $service->getAuthenticatedUser();

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/users', $capturedParams['endpoint']);
        $this->assertSame([], $capturedParams['params']);
    }

    #[Test]
    public function it_exercises_user_wrappers_and_optional_parameters(): void
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
                    '/subscriptions/user' => [
                        'data' => [[
                            'broadcaster_id'    => '12345',
                            'broadcaster_login' => 'twitchdev',
                            'broadcaster_name'  => 'TwitchDev',
                            'tier'              => '1000',
                            'is_gift'           => false,
                        ]],
                    ],
                    '/users' => 'PUT' === $method
                        ? ['data' => [[
                            'id'                => '12345',
                            'login'             => 'zairakai',
                            'display_name'      => 'Zairakai',
                            'type'              => '',
                            'broadcaster_type'  => 'affiliate',
                            'description'       => 'updated',
                            'profile_image_url' => 'https://example.com/avatar.jpg',
                            'offline_image_url' => '',
                            'view_count'        => 1,
                        ]]]
                        : ['data' => []],
                    '/users/extensions/active', '/users/extensions' => ['data' => ['panel' => []]],
                    default => ['data' => [], 'pagination' => []],
                };
            }
        };

        $service->blockUser('u-1', 'spam');
        $service->checkUserSubscription('b-1', 'u-1');
        $service->getAuthorizationByUser();
        $service->getChannelFollowers('b-1', 'u-1', 5, 'cur-1');
        $service->getFollowedChannels('u-1', 'b-1', 5, 'cur-2');
        $service->getSubscriptions('b-1', 'u-1', 5, 'cur-3');
        $service->getUserActiveExtensions('u-1');
        $service->getUserBlocks('b-1', 5, 'cur-4');
        $service->getUserExtensions('u-1');
        $service->getUsers(['1', '2'], ['a', 'b']);
        $service->unblockUser('u-1');
        $service->updateUser('new bio');
        $service->updateUserExtensions(['panel' => []]);

        $this->assertCount(13, $service->calls);
        $this->assertSame('/users/blocks', $service->calls[0]['endpoint']);
        $this->assertSame('/subscriptions/user', $service->calls[1]['endpoint']);
        $this->assertSame('/users/extensions/active', $service->calls[6]['endpoint']);
        $this->assertSame('/users', $service->calls[11]['endpoint']);
        $this->assertSame('PUT', $service->calls[11]['method']);
    }

    // ── getAuthenticatedUser ──────────────────────────────────────────────────

    #[Test]
    public function it_returns_a_user_dto_for_the_authenticated_user(): void
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
                            'id'                => '12345',
                            'login'             => 'teststreamer',
                            'display_name'      => 'TestStreamer',
                            'type'              => '',
                            'broadcaster_type'  => 'affiliate',
                            'description'       => 'Hello world',
                            'profile_image_url' => 'https://example.com/avatar.jpg',
                            'offline_image_url' => '',
                            'view_count'        => 1000,
                            'created_at'        => '2020-01-01T00:00:00Z',
                        ],
                    ],
                ];
            }
        };

        $user = $service->getAuthenticatedUser();

        $this->assertInstanceOf(User::class, $user);
        $this->assertSame('12345', $user->id);
        $this->assertSame('teststreamer', $user->login);
        $this->assertSame('TestStreamer', $user->displayName);
    }

    #[Test]
    public function it_returns_null_when_no_user_data_is_returned(): void
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

        $this->assertNull($service->getAuthenticatedUser());
    }
}
