<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Streams;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Streams\Clip;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class ClipTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $clip = Clip::from([
            'id'               => 'AwkwardHelp',
            'url'              => 'https://clips.twitch.tv/AwkwardHelp',
            'embed_url'        => 'https://clips.twitch.tv/embed?clip=AwkwardHelp',
            'broadcaster_id'   => '12345',
            'broadcaster_name' => 'TwitchDev',
            'creator_id'       => '99999',
            'creator_name'     => 'Viewer',
            'video_id'         => 'v123456',
            'game_id'          => '21779',
            'language'         => 'en',
            'title'            => 'Epic moment',
            'view_count'       => 5432,
            'duration'         => 30.5,
            'vod_offset'       => 1234,
            'created_at'       => '2024-01-15T12:00:00Z',
            'thumbnail_url'    => 'https://example.com/thumb.jpg',
            'is_featured'      => false,
        ]);

        $this->assertSame('AwkwardHelp', $clip->id);
        $this->assertSame(5432, $clip->viewCount);
        $this->assertSame(30.5, $clip->duration);
        $this->assertSame(1234, $clip->vodOffset);
        $this->assertInstanceOf(Carbon::class, $clip->createdAt);
        $this->assertFalse($clip->isFeatured);
    }
}
