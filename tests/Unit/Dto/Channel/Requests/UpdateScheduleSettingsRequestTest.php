<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Channel\Requests;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Channel\Requests\UpdateScheduleSettingsRequest;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class UpdateScheduleSettingsRequestTest extends TestCase
{
    #[Test]
    public function it_serializes_vacation_settings_for_the_api(): void
    {
        $updateScheduleSettingsRequest = new UpdateScheduleSettingsRequest(
            isVacationEnabled: true,
            vacationStartTime: '2024-08-01T00:00:00Z',
            vacationEndTime: '2024-08-15T00:00:00Z',
            timezone: 'Europe/Paris',
        );

        $array = $updateScheduleSettingsRequest->toArray();

        $this->assertTrue($array['is_vacation_enabled']);
        $this->assertSame('2024-08-01T00:00:00Z', $array['vacation_start_time']);
        $this->assertSame('Europe/Paris', $array['timezone']);
    }
}
