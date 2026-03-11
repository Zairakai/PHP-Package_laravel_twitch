<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Goals;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Goals\Goal;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class GoalTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $goal = Goal::from([
            'id'                => 'goal-001',
            'broadcaster_id'    => '12345',
            'broadcaster_login' => 'twitchdev',
            'broadcaster_name'  => 'TwitchDev',
            'type'              => 'follower',
            'description'       => 'Reach 1000 followers!',
            'current_amount'    => 750,
            'target_amount'     => 1000,
            'created_at'        => '2024-02-01T00:00:00Z',
        ]);

        $this->assertSame('goal-001', $goal->id);
        $this->assertSame('follower', $goal->type);
        $this->assertSame(750, $goal->currentAmount);
        $this->assertSame(1000, $goal->targetAmount);
        $this->assertInstanceOf(Carbon::class, $goal->createdAt);
    }
}
