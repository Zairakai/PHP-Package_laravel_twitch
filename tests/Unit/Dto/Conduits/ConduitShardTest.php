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

        $this->assertSame('shard-1', $conduitShard->id);
        $this->assertSame('enabled', $conduitShard->status);
        $this->assertIsArray($conduitShard->transport);
        $this->assertSame('webhook', $conduitShard->transport['method']);
        $this->assertSame('https://example.com/webhook', $conduitShard->transport['callback']);
    }

    #[Test]
    public function it_defaults_transport_to_empty_array(): void
    {
        $conduitShard = ConduitShard::from([
            'id'     => 'shard-2',
            'status' => 'disabled',
        ]);

        $this->assertSame('shard-2', $conduitShard->id);
        $this->assertSame('disabled', $conduitShard->status);
        $this->assertSame([], $conduitShard->transport);
    }
}
