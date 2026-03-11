<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Raids;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Raids\Raid;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class RaidTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $raid = Raid::from([
            'created_at' => '2024-05-01T20:00:00Z',
            'is_mature'  => true,
        ]);

        $this->assertInstanceOf(Carbon::class, $raid->createdAt);
        $this->assertTrue($raid->isMature);
    }

    #[Test]
    public function it_defaults_to_non_mature_with_null_date(): void
    {
        $raid = Raid::from([]);

        $this->assertNull($raid->createdAt);
        $this->assertFalse($raid->isMature);
    }
}
