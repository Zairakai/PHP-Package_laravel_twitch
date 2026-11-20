<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Streams;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Streams\Video;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class VideoTest extends TestCase
{
    #[Test]
    public function it_accepts_null_muted_segments(): void
    {
        // Twitch answers null (not []) for muted_segments with an app access token: the DTO used to throw a TypeError.
        $video = Video::from([
            'id'             => '1',
            'stream_id'      => null,
            'user_id'        => '12826',
            'user_login'     => 'twitch',
            'user_name'      => 'Twitch',
            'title'          => 'A video',
            'description'    => '',
            'viewable'       => 'public',
            'view_count'     => 10,
            'language'       => 'en',
            'type'           => 'archive',
            'duration'       => '1h2m3s',
            'thumbnail_url'  => 'https://example.com/%{width}x%{height}.jpg',
            'url'            => 'https://example.com/v/1',
            'muted_segments' => null,
        ]);

        self::assertNull($video->mutedSegments);
    }

    #[Test]
    public function it_keeps_the_muted_segments_when_given(): void
    {
        $video = Video::from([
            'id'             => '1',
            'stream_id'      => null,
            'user_id'        => '12826',
            'user_login'     => 'twitch',
            'user_name'      => 'Twitch',
            'title'          => 'A video',
            'description'    => '',
            'viewable'       => 'public',
            'view_count'     => 10,
            'language'       => 'en',
            'type'           => 'archive',
            'duration'       => '1h2m3s',
            'thumbnail_url'  => 'https://example.com/%{width}x%{height}.jpg',
            'url'            => 'https://example.com/v/1',
            'muted_segments' => [
                [
                    'offset'   => 10,
                    'duration' => 5,
                ],
            ],
        ]);

        self::assertSame([
            [
                'offset'   => 10,
                'duration' => 5,
            ],
        ], $video->mutedSegments);
    }
}
