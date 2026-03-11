<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\GuestStar\GuestStarSession;
use Zairakai\LaravelTwitch\Dto\GuestStar\GuestStarSettings;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasGuestStarMethodsTest extends TestCase
{
    // ── getChannelGuestStarSettings ───────────────────────────────────────────

    #[Test]
    public function it_calls_the_guest_star_channel_settings_endpoint(): void
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
                            'broadcaster_id'                  => '1',
                            'is_moderator_send_live_enabled'  => true,
                            'slot_count'                      => 5,
                            'is_browser_source_audio_enabled' => false,
                            'group_layout'                    => 'TILED_LAYOUT',
                        ],
                    ],
                ];
            }
        };

        $service->getChannelGuestStarSettings('1', '2');

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/guest_star/channel_settings', $capturedParams['endpoint']);
    }

    // ── getGuestStarSession ───────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_guest_star_session_endpoint(): void
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

                return ['data' => [['id' => 'sess-1', 'guests' => []]]];
            }
        };

        $service->getGuestStarSession('1', '2');

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/guest_star/session', $capturedParams['endpoint']);
    }

    #[Test]
    public function it_returns_a_guest_star_session_dto(): void
    {
        $service = new class('client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                return ['data' => [['id' => 'sess-1', 'guests' => []]]];
            }
        };

        $guestStarSession = $service->getGuestStarSession('1', '2');

        $this->assertInstanceOf(GuestStarSession::class, $guestStarSession);
        $this->assertSame('sess-1', $guestStarSession->id);
        $this->assertSame([], $guestStarSession->guests);
    }

    #[Test]
    public function it_returns_a_guest_star_settings_dto(): void
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
                            'broadcaster_id'                  => '1',
                            'is_moderator_send_live_enabled'  => true,
                            'slot_count'                      => 5,
                            'is_browser_source_audio_enabled' => false,
                            'group_layout'                    => 'TILED_LAYOUT',
                        ],
                    ],
                ];
            }
        };

        $guestStarSettings = $service->getChannelGuestStarSettings('1', '2');

        $this->assertInstanceOf(GuestStarSettings::class, $guestStarSettings);
        $this->assertSame('1', $guestStarSettings->broadcasterId);
        $this->assertSame(5, $guestStarSettings->slotCount);
        $this->assertSame('TILED_LAYOUT', $guestStarSettings->groupLayout);
    }
}
