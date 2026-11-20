<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Channel;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Channel\ScheduleSegment;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class ScheduleSegmentTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $scheduleSegment = ScheduleSegment::from([
            'id'             => 'seg-001',
            'title'          => 'Weekly stream',
            'is_recurring'   => true,
            'start_time'     => '2024-03-04T18:00:00Z',
            'end_time'       => '2024-03-04T21:00:00Z',
            'canceled_until' => null,
            'category'       => [
                'id'   => '21779',
                'name' => 'League of Legends',
            ],
        ]);

        self::assertSame('seg-001', $scheduleSegment->id);
        self::assertSame('Weekly stream', $scheduleSegment->title);
        self::assertTrue($scheduleSegment->isRecurring);
        self::assertInstanceOf(Carbon::class, $scheduleSegment->startTime);
        self::assertInstanceOf(Carbon::class, $scheduleSegment->endTime);
        self::assertNull($scheduleSegment->canceledUntil);
        self::assertNotNull($scheduleSegment->category);
        self::assertSame('21779', $scheduleSegment->category['id']);
    }

    #[Test]
    public function it_handles_null_optional_fields(): void
    {
        $scheduleSegment = ScheduleSegment::from([
            'id'           => 'seg-002',
            'title'        => 'Special event',
            'is_recurring' => false,
        ]);

        self::assertNull($scheduleSegment->startTime);
        self::assertNull($scheduleSegment->endTime);
        self::assertNull($scheduleSegment->category);
    }
}
