<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Streams;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Streams\StreamMarker;
use Zairakai\LaravelTwitch\Dto\Streams\StreamMarkerVideo;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class StreamMarkerVideoTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_snake_case_array(): void
    {
        $streamMarkerVideo = StreamMarkerVideo::from([
            'video_id' => 'vid-abc',
            'markers'  => [
                [
                    'id'                  => 'marker-1',
                    'created_at'          => '2024-01-15T10:30:00Z',
                    'description'         => 'Epic moment',
                    'position_seconds'    => 3600,
                    'url'                 => 'https://www.twitch.tv/videos/vid-abc?t=01h00m00s',
                ],
            ],
        ]);

        $this->assertSame('vid-abc', $streamMarkerVideo->videoId);
        $this->assertCount(1, $streamMarkerVideo->markers);
        $this->assertInstanceOf(StreamMarker::class, $streamMarkerVideo->markers->first());
    }

    #[Test]
    public function it_handles_empty_markers(): void
    {
        $streamMarkerVideo = StreamMarkerVideo::from([
            'video_id' => 'vid-xyz',
            'markers'  => [],
        ]);

        $this->assertSame('vid-xyz', $streamMarkerVideo->videoId);
        $this->assertCount(0, $streamMarkerVideo->markers);
    }
}
