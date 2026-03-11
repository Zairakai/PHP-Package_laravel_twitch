<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Conduits\Requests;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Conduits\Requests\UpdateConduitShardRequest;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class UpdateConduitShardRequestTest extends TestCase
{
    #[Test]
    public function it_serializes_id_and_transport_for_the_api(): void
    {
        $updateConduitShardRequest = new UpdateConduitShardRequest(
            id: 'shard-1',
            transport: [
                'method'   => 'webhook',
                'callback' => 'https://example.com/webhook',
                'secret'   => 's3cr3t',
            ],
        );

        $array = $updateConduitShardRequest->toArray();

        $this->assertSame('shard-1', $array['id']);
        $this->assertSame('webhook', $array['transport']['method']);
        $this->assertSame('https://example.com/webhook', $array['transport']['callback']);
    }
}
