<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Streams;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Streams\StreamMarker;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class StreamMarkerTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $streamMarker = StreamMarker::from([
            'id'                  => 'marker-001',
            'description'         => 'Epic moment',
            'position_seconds'    => 3600,
            'is_editor_highlight' => true,
            'url'                 => 'https://www.twitch.tv/videos/123?t=1h',
            'broadcaster_id'      => '12345',
            'created_at'          => '2024-03-01T19:00:00Z',
        ]);

        self::assertSame('marker-001', $streamMarker->id);
        self::assertSame('Epic moment', $streamMarker->description);
        self::assertSame(3600, $streamMarker->positionSeconds);
        self::assertTrue($streamMarker->isEditorHighlight);
        self::assertInstanceOf(Carbon::class, $streamMarker->createdAt);
    }

    #[Test]
    public function it_defaults_optional_fields_to_null(): void
    {
        $streamMarker = StreamMarker::from([
            'id' => 'marker-002',
        ]);

        self::assertNull($streamMarker->description);
        self::assertNull($streamMarker->positionSeconds);
        self::assertNull($streamMarker->createdAt);
    }
}
