<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Streams;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Streams\Video;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class VideoTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $video = Video::from([
            'id'             => 'v123456',
            'stream_id'      => 's789',
            'user_id'        => '12345',
            'user_login'     => 'twitchdev',
            'user_name'      => 'TwitchDev',
            'title'          => 'Best moments',
            'description'    => 'Highlights from last stream',
            'viewable'       => 'public',
            'view_count'     => 9999,
            'language'       => 'en',
            'type'           => 'highlight',
            'duration'       => '1h23m45s',
            'thumbnail_url'  => 'https://example.com/thumb.jpg',
            'url'            => 'https://www.twitch.tv/videos/123456',
            'created_at'     => '2024-03-01T00:00:00Z',
            'published_at'   => '2024-03-01T01:00:00Z',
            'muted_segments' => [],
        ]);

        $this->assertSame('v123456', $video->id);
        $this->assertSame('s789', $video->streamId);
        $this->assertSame('highlight', $video->type);
        $this->assertSame('1h23m45s', $video->duration);
        $this->assertInstanceOf(Carbon::class, $video->createdAt);
        $this->assertInstanceOf(Carbon::class, $video->publishedAt);
    }

    #[Test]
    public function it_handles_null_stream_id(): void
    {
        $video = Video::from([
            'id'            => 'v999',
            'stream_id'     => null,
            'user_id'       => '12345',
            'user_login'    => 'twitchdev',
            'user_name'     => 'TwitchDev',
            'title'         => 'Old VOD',
            'description'   => '',
            'viewable'      => 'public',
            'view_count'    => 0,
            'language'      => 'en',
            'type'          => 'archive',
            'duration'      => '3h00m00s',
            'thumbnail_url' => '',
            'url'           => 'https://www.twitch.tv/videos/999',
        ]);

        $this->assertNull($video->streamId);
    }
}
