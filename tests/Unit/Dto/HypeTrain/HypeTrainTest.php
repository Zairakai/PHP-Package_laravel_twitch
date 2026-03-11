<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\HypeTrain;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\HypeTrain\HypeTrain;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HypeTrainTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $hypeTrain = HypeTrain::from([
            'id'                 => 'ht-001',
            'event_type'         => 'hypetrain.progression',
            'broadcaster_id'     => '12345',
            'level'              => 2,
            'total'              => 3500,
            'progress'           => 500,
            'goal'               => 1500,
            'top_contributions'  => [['user_id' => '99999', 'type' => 'BITS', 'total' => 2000]],
            'last_contribution'  => ['user_id' => '88888', 'type' => 'SUBS', 'total' => 500],
            'started_at'         => '2024-03-01T10:00:00Z',
            'expires_at'         => '2024-03-01T10:05:00Z',
            'cooldown_end_time'  => '2024-03-01T11:00:00Z',
            'event_timestamp'    => '2024-03-01T10:02:00Z',
        ]);

        $this->assertSame('ht-001', $hypeTrain->id);
        $this->assertSame(2, $hypeTrain->level);
        $this->assertSame(3500, $hypeTrain->total);
        $this->assertSame(500, $hypeTrain->progress);
        $this->assertCount(1, $hypeTrain->topContributions);
        $this->assertIsArray($hypeTrain->lastContribution);
        $this->assertInstanceOf(Carbon::class, $hypeTrain->startedAt);
        $this->assertInstanceOf(Carbon::class, $hypeTrain->expiresAt);
    }

    #[Test]
    public function it_handles_null_optional_fields(): void
    {
        $hypeTrain = HypeTrain::from([
            'id'                => 'ht-002',
            'event_type'        => 'hypetrain.begin',
            'broadcaster_id'    => '12345',
            'level'             => 1,
            'total'             => 0,
            'progress'          => 0,
            'goal'              => 1000,
            'top_contributions' => [],
        ]);

        $this->assertNull($hypeTrain->lastContribution);
        $this->assertNull($hypeTrain->startedAt);
        $this->assertNull($hypeTrain->expiresAt);
    }
}
