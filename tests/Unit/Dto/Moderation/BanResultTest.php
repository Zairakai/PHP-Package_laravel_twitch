<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Moderation;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Moderation\BanResult;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class BanResultTest extends TestCase
{
    #[Test]
    public function it_can_be_created_for_timed_ban(): void
    {
        $banResult = BanResult::from([
            'broadcaster_id' => '12345',
            'moderator_id'   => '67890',
            'user_id'        => '11111',
            'created_at'     => '2024-01-01T00:00:00Z',
            'end_time'       => '2024-01-08T00:00:00Z',
        ]);

        $this->assertSame('12345', $banResult->broadcasterId);
        $this->assertSame('67890', $banResult->moderatorId);
        $this->assertSame('11111', $banResult->userId);
        $this->assertSame('2024-01-01T00:00:00Z', $banResult->createdAt);
        $this->assertSame('2024-01-08T00:00:00Z', $banResult->endTime);
    }

    #[Test]
    public function it_handles_permanent_ban(): void
    {
        $banResult = BanResult::from([
            'broadcaster_id' => '12345',
            'moderator_id'   => '67890',
            'user_id'        => '11111',
            'created_at'     => '2024-01-01T00:00:00Z',
        ]);

        $this->assertNull($banResult->endTime);
    }
}
