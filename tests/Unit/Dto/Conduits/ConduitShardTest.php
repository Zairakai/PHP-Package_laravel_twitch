<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Conduits;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Conduits\ConduitShard;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class ConduitShardTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $conduitShard = ConduitShard::from([
            'id'        => 'shard-1',
            'status'    => 'enabled',
            'transport' => [
                'method'   => 'webhook',
                'callback' => 'https://example.com/webhook',
            ],
        ]);

        self::assertSame('shard-1', $conduitShard->id);
        self::assertSame('enabled', $conduitShard->status);
        self::assertIsArray($conduitShard->transport);
        self::assertSame('webhook', $conduitShard->transport['method']);
        self::assertSame('https://example.com/webhook', $conduitShard->transport['callback']);
    }

    #[Test]
    public function it_defaults_transport_to_empty_array(): void
    {
        $conduitShard = ConduitShard::from([
            'id'     => 'shard-2',
            'status' => 'disabled',
        ]);

        self::assertSame('shard-2', $conduitShard->id);
        self::assertSame('disabled', $conduitShard->status);
        self::assertSame([], $conduitShard->transport);
    }
}
