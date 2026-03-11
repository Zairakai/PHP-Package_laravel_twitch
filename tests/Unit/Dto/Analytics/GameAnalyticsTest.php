<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Analytics;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Analytics\GameAnalytics;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class GameAnalyticsTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $gameAnalytics = GameAnalytics::from([
            'game_id'    => '54321',
            'url'        => 'http://example.com/game-report.csv',
            'type'       => 'overview_v2',
            'date_range' => [
                'started_at' => '2021-01-01T00:00:00Z',
                'ended_at'   => '2021-01-31T23:59:59Z',
            ],
        ]);

        $this->assertSame('54321', $gameAnalytics->gameId);
        $this->assertSame('http://example.com/game-report.csv', $gameAnalytics->url);
        $this->assertSame('overview_v2', $gameAnalytics->type);
        $this->assertIsArray($gameAnalytics->dateRange);
        $this->assertSame('2021-01-01T00:00:00Z', $gameAnalytics->dateRange['started_at']);
    }
}
