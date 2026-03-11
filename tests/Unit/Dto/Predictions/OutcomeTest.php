<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Predictions;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Predictions\Outcome;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class OutcomeTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $outcome = Outcome::from([
            'id'             => 'outcome-001',
            'title'          => 'Yes',
            'channel_points' => 5000,
            'users'          => 25,
            'color'          => 'BLUE',
            'top_predictors' => [
                ['user_id' => '11111', 'user_login' => 'top1', 'channel_points_won' => 2000],
            ],
        ]);

        $this->assertSame('outcome-001', $outcome->id);
        $this->assertSame('Yes', $outcome->title);
        $this->assertSame(5000, $outcome->channelPoints);
        $this->assertSame('BLUE', $outcome->color);
        $this->assertCount(1, $outcome->topPredictors);
    }

    #[Test]
    public function it_defaults_top_predictors_to_empty_array(): void
    {
        $outcome = Outcome::from([
            'id'             => 'outcome-002',
            'title'          => 'No',
            'channel_points' => 0,
            'users'          => 0,
            'color'          => 'PINK',
        ]);

        $this->assertSame([], $outcome->topPredictors);
    }
}
