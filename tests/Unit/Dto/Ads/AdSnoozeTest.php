<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Ads;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Ads\AdSnooze;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class AdSnoozeTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $adSnooze = AdSnooze::from([
            'broadcaster_id'    => '12345',
            'snooze_count'      => 3,
            'snooze_refresh_at' => '2021-01-01T00:00:00Z',
            'next_ad_at'        => '2021-01-01T01:00:00Z',
        ]);

        $this->assertSame('12345', $adSnooze->broadcasterId);
        $this->assertSame(3, $adSnooze->snoozeCount);
        $this->assertInstanceOf(Carbon::class, $adSnooze->snoozeRefreshAt);
        $this->assertSame('2021-01-01 00:00:00', $adSnooze->snoozeRefreshAt->toDateTimeString());
        $this->assertInstanceOf(Carbon::class, $adSnooze->nextAdAt);
        $this->assertSame('2021-01-01 01:00:00', $adSnooze->nextAdAt->toDateTimeString());
    }

    #[Test]
    public function it_handles_null_dates(): void
    {
        $adSnooze = AdSnooze::from([
            'broadcaster_id'    => '12345',
            'snooze_count'      => 0,
            'snooze_refresh_at' => null,
            'next_ad_at'        => null,
        ]);

        $this->assertSame('12345', $adSnooze->broadcasterId);
        $this->assertSame(0, $adSnooze->snoozeCount);
        $this->assertNull($adSnooze->snoozeRefreshAt);
        $this->assertNull($adSnooze->nextAdAt);
    }
}
