<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Streams;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Streams\Stream;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class StreamTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $stream = Stream::from([
            'id'            => 'stream-001',
            'user_id'       => '12345',
            'user_login'    => 'twitchdev',
            'user_name'     => 'TwitchDev',
            'game_id'       => '21779',
            'game_name'     => 'League of Legends',
            'type'          => 'live',
            'title'         => 'Playing ranked!',
            'viewer_count'  => 1250,
            'language'      => 'en',
            'thumbnail_url' => 'https://example.com/thumb.jpg',
            'is_mature'     => false,
            'started_at'    => '2024-03-01T18:00:00Z',
            'tags'          => ['FPS'],
        ]);

        $this->assertSame('stream-001', $stream->id);
        $this->assertSame('live', $stream->type);
        $this->assertSame(1250, $stream->viewerCount);
        $this->assertFalse($stream->isMature);
        $this->assertInstanceOf(Carbon::class, $stream->startedAt);
        $this->assertSame(['FPS'], $stream->tags);
    }
}
