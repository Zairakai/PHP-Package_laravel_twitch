<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Streams;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Streams\StreamMarkerGroup;
use Zairakai\LaravelTwitch\Dto\Streams\StreamMarkerVideo;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class StreamMarkerGroupTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_snake_case_array(): void
    {
        $streamMarkerGroup = StreamMarkerGroup::from([
            'user_id'    => '12345',
            'user_login' => 'zairakai',
            'user_name'  => 'Zairakai',
            'videos'     => [
                [
                    'video_id' => 'vid-1',
                    'markers'  => [],
                ],
            ],
        ]);

        self::assertSame('12345', $streamMarkerGroup->userId);
        self::assertSame('zairakai', $streamMarkerGroup->userLogin);
        self::assertSame('Zairakai', $streamMarkerGroup->userName);
        self::assertCount(1, $streamMarkerGroup->videos);
        self::assertInstanceOf(StreamMarkerVideo::class, $streamMarkerGroup->videos->first());
    }
}
