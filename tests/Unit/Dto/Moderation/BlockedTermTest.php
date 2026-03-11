<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Moderation;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Moderation\BlockedTerm;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class BlockedTermTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $blockedTerm = BlockedTerm::from([
            'id'             => 'term-001',
            'broadcaster_id' => '12345',
            'moderator_id'   => '67890',
            'text'           => 'badword',
            'created_at'     => '2024-01-01T00:00:00Z',
            'updated_at'     => '2024-01-02T00:00:00Z',
            'expires_at'     => null,
        ]);

        $this->assertSame('term-001', $blockedTerm->id);
        $this->assertSame('badword', $blockedTerm->text);
        $this->assertInstanceOf(Carbon::class, $blockedTerm->createdAt);
        $this->assertInstanceOf(Carbon::class, $blockedTerm->updatedAt);
        $this->assertNull($blockedTerm->expiresAt);
    }
}
