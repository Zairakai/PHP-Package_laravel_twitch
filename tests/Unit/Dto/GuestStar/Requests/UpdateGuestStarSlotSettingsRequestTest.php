<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\GuestStar\Requests;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\GuestStar\Requests\UpdateGuestStarSlotSettingsRequest;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class UpdateGuestStarSlotSettingsRequestTest extends TestCase
{
    #[Test]
    public function it_serializes_non_null_fields_to_snake_case(): void
    {
        $updateGuestStarSlotSettingsRequest = new UpdateGuestStarSlotSettingsRequest(
            isAudioEnabled: true,
            isVideoEnabled: false,
            volume: 80,
        );

        $array = $updateGuestStarSlotSettingsRequest->toArray();

        self::assertTrue($array['is_audio_enabled']);
        self::assertFalse($array['is_video_enabled']);
        self::assertSame(80, $array['volume']);
        self::assertNull($array['is_live']);
    }
}
