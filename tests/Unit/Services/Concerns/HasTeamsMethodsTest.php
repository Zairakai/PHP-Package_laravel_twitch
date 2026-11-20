<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Teams\Team;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasTeamsMethodsTest extends TestCase
{
    // ── getChannelTeams ───────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_channel_teams_endpoint(): void
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
            protected function makeRequest(
                string $method,
                string $endpoint,
                array $params = [],
            ): array {
                $this->captured = [
                    'method'   => $method,
                    'endpoint' => $endpoint,
                    'params'   => $params,
                ];

                return [
                    'data' => [],
                ];
            }
        };

        $service->getChannelTeams('1');

        self::assertIsArray($capturedParams);
        self::assertSame('GET', $capturedParams['method']);
        self::assertSame('/teams/channel', $capturedParams['endpoint']);
        self::assertSame([
            'broadcaster_id' => '1',
        ], $capturedParams['params']);
    }

    // ── getTeams ──────────────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_teams_endpoint(): void
    {
        $capturedParams = null;
        $teamData       = $this->teamData();

        $service = new class($teamData, 'client-id', 'secret', $capturedParams) extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $teamData
             */
            public function __construct(
                private readonly array $teamData,
                string $clientId,
                string $clientSecret,
                public mixed &$captured,
            ) {
                parent::__construct($clientId, $clientSecret);
            }

            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(
                string $method,
                string $endpoint,
                array $params = [],
            ): array {
                $this->captured = [
                    'method'   => $method,
                    'endpoint' => $endpoint,
                    'params'   => $params,
                ];

                return [
                    'data' => [
                        $this->teamData,
                    ],
                ];
            }
        };

        $service->getTeams(name: 'awesome-team');

        self::assertIsArray($capturedParams);
        self::assertSame('GET', $capturedParams['method']);
        self::assertSame('/teams', $capturedParams['endpoint']);
    }

    #[Test]
    public function it_returns_a_data_collection_of_teams(): void
    {
        $teamData = $this->teamData();

        $service = new class($teamData, 'client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $teamData
             */
            public function __construct(
                private readonly array $teamData,
                string $clientId,
                string $clientSecret,
            ) {
                parent::__construct($clientId, $clientSecret);
            }

            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(
                string $method,
                string $endpoint,
                array $params = [],
            ): array {
                return [
                    'data' => [
                        $this->teamData,
                    ],
                ];
            }
        };

        $dataCollection = $service->getChannelTeams('1');

        self::assertInstanceOf(Team::class, $dataCollection->first());
        self::assertSame('team-1', $dataCollection->first()->id);
        self::assertSame('awesome-team', $dataCollection->first()->teamName);
    }

    #[Test]
    public function it_returns_a_team_dto(): void
    {
        $teamData = $this->teamData();

        $service = new class($teamData, 'client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $teamData
             */
            public function __construct(
                private readonly array $teamData,
                string $clientId,
                string $clientSecret,
            ) {
                parent::__construct($clientId, $clientSecret);
            }

            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(
                string $method,
                string $endpoint,
                array $params = [],
            ): array {
                return [
                    'data' => [
                        $this->teamData,
                    ],
                ];
            }
        };

        $team = $service->getTeams(name: 'awesome-team');

        self::assertSame('team-1', $team->id);
        self::assertSame('Awesome Team', $team->teamDisplayName);
    }

    /**
     * @return array<string, mixed>
     */
    private function teamData(): array
    {
        return [
            'id'                   => 'team-1',
            'team_name'            => 'awesome-team',
            'team_display_name'    => 'Awesome Team',
            'info'                 => 'The best team on Twitch',
            'thumbnail_url'        => 'https://example.com/thumb.jpg',
            'background_image_url' => 'https://example.com/bg.jpg',
            'banner'               => 'https://example.com/banner.jpg',
        ];
    }
}
