<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\GuestStar\Requests;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\GuestStar\Requests\UpdateGuestStarSettingsRequest;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class UpdateGuestStarSettingsRequestTest extends TestCase
{
    #[Test]
    public function it_serializes_non_null_fields_to_snake_case(): void
    {
        $updateGuestStarSettingsRequest = new UpdateGuestStarSettingsRequest(
            isModeratorSendLiveEnabled: true,
            slotCount: 4,
            groupLayout: 'TILED_LAYOUT',
        );

        $array = $updateGuestStarSettingsRequest->toArray();

        $this->assertTrue($array['is_moderator_send_live_enabled']);
        $this->assertSame(4, $array['slot_count']);
        $this->assertSame('TILED_LAYOUT', $array['group_layout']);
        $this->assertNull($array['is_browser_source_audio_enabled']);
        $this->assertNull($array['regenerate_browser_sources']);
    }
}
