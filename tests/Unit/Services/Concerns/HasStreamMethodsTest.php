<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;
use Zairakai\LaravelTwitch\Dto\Streams\Clip;
use Zairakai\LaravelTwitch\Dto\Streams\Stream;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasStreamMethodsTest extends TestCase
{
    // ── getClips ──────────────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_clips_endpoint(): void
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

                return ['data' => [], 'pagination' => ['cursor' => '']];
            }
        };

        $service->getClips(broadcasterId: '1');

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/clips', $capturedParams['endpoint']);
    }

    // ── getStreams ─────────────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_streams_endpoint(): void
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

                return ['data' => [], 'pagination' => ['cursor' => '']];
            }
        };

        $service->getStreams();

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/streams', $capturedParams['endpoint']);
    }

    #[Test]
    public function it_exercises_stream_wrappers_for_clips_videos_and_markers(): void
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
                    '/clips' => 'POST' === $method
                        ? ['data' => [[
                            'id'       => 'clip-edit-1',
                            'edit_url' => 'https://clips.twitch.tv/clip-edit-1/edit',
                        ]], 'pagination' => []]
                        : ['data' => [[
                            'id'               => 'clip-1',
                            'url'              => 'https://example.com/clip',
                            'embed_url'        => 'https://example.com/embed',
                            'broadcaster_id'   => '1',
                            'broadcaster_name' => 'Test',
                            'creator_id'       => '2',
                            'creator_name'     => 'Creator',
                            'video_id'         => 'vid-1',
                            'game_id'          => 'game-1',
                            'language'         => 'en',
                            'title'            => 'Epic clip',
                            'view_count'       => 50,
                            'duration'         => 30.0,
                            'vod_offset'       => null,
                            'created_at'       => '2024-01-01T00:00:00Z',
                            'thumbnail_url'    => 'https://example.com/thumb.jpg',
                            'is_featured'      => false,
                        ]], 'pagination' => []],
                    '/videos/clips' => ['data' => [[
                        'id'       => 'clip-edit-2',
                        'edit_url' => 'https://clips.twitch.tv/clip-edit-2/edit',
                    ]], 'pagination' => []],
                    '/clips/downloads' => ['data' => [[
                        'clip_id'                => 'clip-1',
                        'landscape_download_url' => 'https://cdn.example.com/clip-1-landscape.mp4',
                        'portrait_download_url'  => null,
                    ]]],
                    '/streams/markers' => 'POST' === $method
                        ? ['data' => [[
                            'id'                  => 'marker-1',
                            'description'         => 'desc',
                            'position_seconds'    => 10,
                            'is_editor_highlight' => false,
                            'url'                 => 'https://example.com/marker',
                            'broadcaster_id'      => 'b-1',
                        ]]]
                        : ['data' => [], 'pagination' => []],
                    '/streams/key' => ['data' => [[
                        'broadcaster_id' => 'b-1',
                        'stream_key'     => 'live_xxx',
                    ]]],
                    '/videos' => 'DELETE' === $method
                        ? ['data' => ['v1', 'v2']]
                        : ['data' => [], 'pagination' => []],
                    default => ['data' => [], 'pagination' => []],
                };
            }
        };

        $service->createClip('b-1', 'My clip', 45.0);
        $service->createClipFromVod('e-1', 'b-1', 'vod-1', 120, 'My VOD clip');
        $service->createStreamMarker('u-1', 'marker');

        $deleted = $service->deleteVideo(['v1', 'v2']);
        $service->getClips('b-1', ['clip-1'], 5, 'cur-1');
        $service->getClipsDownloads('e-1', 'b-1', ['clip-1']);
        $service->getFollowedStreams('u-1', 5, 'cur-2');
        $service->getStreamKey('b-1');
        $service->getStreamMarkers('u-1', 'vid-1', 5, 'cur-3');
        $service->getStreams(['u1', 'u2'], ['g1'], ['en'], 5, 'cur-4');
        $service->getVideos('u1', 'g1', ['v1'], 'all', 5, 'cur-5');

        $this->assertCount(11, $service->calls);
        $this->assertSame(['v1', 'v2'], $deleted);
        $this->assertSame('/clips', $service->calls[0]['endpoint']);
        $this->assertSame('/videos', $service->calls[10]['endpoint']);
    }

    #[Test]
    public function it_returns_a_paginated_result_of_clips(): void
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
                            'id'               => 'clip-1',
                            'url'              => 'https://example.com/clip',
                            'embed_url'        => 'https://example.com/embed',
                            'broadcaster_id'   => '1',
                            'broadcaster_name' => 'Test',
                            'creator_id'       => '2',
                            'creator_name'     => 'Creator',
                            'video_id'         => 'vid-1',
                            'game_id'          => 'game-1',
                            'language'         => 'en',
                            'title'            => 'Epic clip',
                            'view_count'       => 50,
                            'duration'         => 30.0,
                            'vod_offset'       => null,
                        ],
                    ],
                    'pagination' => ['cursor' => 'abc123'],
                ];
            }
        };

        $paginatedResult = $service->getClips(broadcasterId: '1');

        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $this->assertCount(1, $paginatedResult->items);
        $this->assertInstanceOf(Clip::class, $paginatedResult->items[0]);
        $this->assertSame('clip-1', $paginatedResult->items[0]->id);
        $this->assertSame('Epic clip', $paginatedResult->items[0]->title);
    }

    #[Test]
    public function it_returns_a_paginated_result_of_streams(): void
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
                            'id'            => 'stream-1',
                            'user_id'       => '1',
                            'user_login'    => 'test',
                            'user_name'     => 'Test',
                            'game_id'       => 'game-1',
                            'game_name'     => 'Fortnite',
                            'type'          => 'live',
                            'title'         => 'Playing!',
                            'viewer_count'  => 100,
                            'started_at'    => '2024-01-01T00:00:00Z',
                            'language'      => 'en',
                            'thumbnail_url' => 'https://example.com/thumb.jpg',
                            'is_mature'     => false,
                        ],
                    ],
                    'pagination' => ['cursor' => 'abc123'],
                ];
            }
        };

        $paginatedResult = $service->getStreams();

        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $this->assertCount(1, $paginatedResult->items);
        $this->assertInstanceOf(Stream::class, $paginatedResult->items[0]);
        $this->assertSame('stream-1', $paginatedResult->items[0]->id);
        $this->assertSame(100, $paginatedResult->items[0]->viewerCount);
    }
}
