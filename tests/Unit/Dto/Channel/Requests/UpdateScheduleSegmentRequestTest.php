<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Channel\Requests;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Channel\Requests\UpdateScheduleSegmentRequest;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class UpdateScheduleSegmentRequestTest extends TestCase
{
    #[Test]
    public function it_can_be_constructed_with_all_nulls(): void
    {
        $updateScheduleSegmentRequest = new UpdateScheduleSegmentRequest();

        self::assertNull($updateScheduleSegmentRequest->title);
        self::assertNull($updateScheduleSegmentRequest->isCanceled);
    }

    #[Test]
    public function it_serializes_to_snake_case_for_the_api(): void
    {
        $updateScheduleSegmentRequest = new UpdateScheduleSegmentRequest(
            title: 'Updated title',
            isCanceled: false,
        );

        $array = $updateScheduleSegmentRequest->toArray();

        self::assertSame('Updated title', $array['title']);
        self::assertFalse($array['is_canceled']);
    }
}
