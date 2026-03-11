<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Conduits;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Conduits\Conduit;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class ConduitTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $conduit = Conduit::from([
            'id'          => 'abc123',
            'shard_count' => 5,
        ]);

        $this->assertSame('abc123', $conduit->id);
        $this->assertSame(5, $conduit->shardCount);
    }
}
