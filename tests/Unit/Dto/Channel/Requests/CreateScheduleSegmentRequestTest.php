<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Channel\Requests;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Channel\Requests\CreateScheduleSegmentRequest;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class CreateScheduleSegmentRequestTest extends TestCase
{
    #[Test]
    public function it_serializes_to_snake_case_for_the_api(): void
    {
        $createScheduleSegmentRequest = new CreateScheduleSegmentRequest(
            startTime: '2024-03-04T18:00:00Z',
            timezone: 'America/New_York',
            duration: 180,
            isRecurring: true,
            categoryId: '21779',
            title: 'Weekly ranked session',
        );

        $array = $createScheduleSegmentRequest->toArray();

        self::assertSame('2024-03-04T18:00:00Z', $array['start_time']);
        self::assertSame('America/New_York', $array['timezone']);
        self::assertSame(180, $array['duration']);
        self::assertTrue($array['is_recurring']);
        self::assertSame('21779', $array['category_id']);
    }
}
