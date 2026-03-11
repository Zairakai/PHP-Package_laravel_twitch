<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Predictions;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Predictions\Prediction;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class PredictionTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $prediction = Prediction::from([
            'id'                 => 'pred-001',
            'broadcaster_id'     => '12345',
            'broadcaster_login'  => 'twitchdev',
            'broadcaster_name'   => 'TwitchDev',
            'title'              => 'Will we win?',
            'status'             => 'ACTIVE',
            'prediction_window'  => 120,
            'outcomes'           => [
                ['id' => 'o1', 'title' => 'Yes', 'channel_points' => 1000, 'users' => 10, 'color' => 'BLUE'],
                ['id' => 'o2', 'title' => 'No',  'channel_points' => 500,  'users' => 5,  'color' => 'PINK'],
            ],
            'created_at' => '2024-03-01T10:00:00Z',
        ]);

        $this->assertSame('pred-001', $prediction->id);
        $this->assertSame('ACTIVE', $prediction->status);
        $this->assertSame(120, $prediction->predictionWindow);
        $this->assertCount(2, $prediction->outcomes);
        $this->assertNull($prediction->winningOutcomeId);
        $this->assertInstanceOf(Carbon::class, $prediction->createdAt);
        $this->assertNull($prediction->lockedAt);
    }
}
