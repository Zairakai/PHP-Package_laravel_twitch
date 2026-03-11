<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Streams;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Streams\StreamKey;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class StreamKeyTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $streamKey = StreamKey::from([
            'broadcaster_id' => '12345',
            'stream_key'     => 'live_12345_abcdefghij',
        ]);

        $this->assertSame('12345', $streamKey->broadcasterId);
        $this->assertSame('live_12345_abcdefghij', $streamKey->streamKey);
    }
}
