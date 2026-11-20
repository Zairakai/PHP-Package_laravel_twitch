<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Ads;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Ads\AdSchedule;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class AdScheduleTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $adSchedule = AdSchedule::from([
            'duration'          => 30,
            'snooze_count'      => 2,
            'preroll_free_time' => 0,
            'next_ad_at'        => '2024-06-01T15:00:00Z',
            'last_ad_at'        => '2024-06-01T14:30:00Z',
            'snooze_refresh_at' => '2024-06-01T14:45:00Z',
        ]);

        self::assertSame(30, $adSchedule->duration);
        self::assertSame(2, $adSchedule->snoozeCount);
        self::assertSame(0, $adSchedule->prerollFreeTime);
        self::assertInstanceOf(Carbon::class, $adSchedule->nextAdAt);
        self::assertInstanceOf(Carbon::class, $adSchedule->lastAdAt);
        self::assertInstanceOf(Carbon::class, $adSchedule->snoozeRefreshAt);
    }

    #[Test]
    public function it_handles_null_date_fields(): void
    {
        $adSchedule = AdSchedule::from([
            'duration'          => 60,
            'snooze_count'      => 0,
            'preroll_free_time' => 90,
        ]);

        self::assertSame(60, $adSchedule->duration);
        self::assertNull($adSchedule->nextAdAt);
        self::assertNull($adSchedule->lastAdAt);
        self::assertNull($adSchedule->snoozeRefreshAt);
    }
}
