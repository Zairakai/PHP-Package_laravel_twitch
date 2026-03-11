<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Channel;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Channel\Schedule;
use Zairakai\LaravelTwitch\Dto\Channel\ScheduleSegment;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class ScheduleTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_snake_case_array(): void
    {
        $schedule = Schedule::from([
            'broadcaster_id'    => '99999',
            'broadcaster_name'  => 'Zairakai',
            'broadcaster_login' => 'zairakai',
            'segments'          => [
                [
                    'id'           => 'eyJzZWdtZW50SUQiOiJlNGFjYzcyNC0zNzFmLTQ0MDItODk0Ny1lMWVlMTI',
                    'start_time'   => '2024-01-15T18:00:00Z',
                    'end_time'     => '2024-01-15T20:00:00Z',
                    'title'        => 'Stream time!',
                    'is_recurring' => false,
                ],
            ],
        ]);

        $this->assertSame('99999', $schedule->broadcasterId);
        $this->assertSame('Zairakai', $schedule->broadcasterName);
        $this->assertSame('zairakai', $schedule->broadcasterLogin);
        $this->assertCount(1, $schedule->segments);
        $this->assertInstanceOf(ScheduleSegment::class, $schedule->segments->first());
        $this->assertNull($schedule->vacation);
    }

    #[Test]
    public function it_maps_vacation_period_when_present(): void
    {
        $schedule = Schedule::from([
            'broadcaster_id'    => '99999',
            'broadcaster_name'  => 'Zairakai',
            'broadcaster_login' => 'zairakai',
            'segments'          => [],
            'vacation'          => [
                'start_time' => '2024-02-01T00:00:00Z',
                'end_time'   => '2024-02-15T00:00:00Z',
            ],
        ]);

        $this->assertIsArray($schedule->vacation);
        $this->assertSame('2024-02-01T00:00:00Z', $schedule->vacation['start_time']);
    }
}
