<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Analytics;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Analytics\ExtensionAnalytics;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class ExtensionAnalyticsTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $extensionAnalytics = ExtensionAnalytics::from([
            'extension_id' => 'abcde',
            'url'          => 'http://example.com/report.csv',
            'type'         => 'overview_v2',
            'date_range'   => [
                'started_at' => '2021-01-01T00:00:00Z',
                'ended_at'   => '2021-01-31T23:59:59Z',
            ],
        ]);

        $this->assertSame('abcde', $extensionAnalytics->extensionId);
        $this->assertSame('http://example.com/report.csv', $extensionAnalytics->url);
        $this->assertSame('overview_v2', $extensionAnalytics->type);
        $this->assertIsArray($extensionAnalytics->dateRange);
        $this->assertSame('2021-01-01T00:00:00Z', $extensionAnalytics->dateRange['started_at']);
    }
}
