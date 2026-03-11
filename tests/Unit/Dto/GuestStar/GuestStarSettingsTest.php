<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\GuestStar;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\GuestStar\GuestStarSettings;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class GuestStarSettingsTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $guestStarSettings = GuestStarSettings::from([
            'broadcaster_id'                  => '98765',
            'is_moderator_send_live_enabled'  => true,
            'slot_count'                      => 5,
            'is_browser_source_audio_enabled' => false,
            'group_layout'                    => 'TILED_LAYOUT',
            'browser_source_token'            => 'token-xyz',
        ]);

        $this->assertSame('98765', $guestStarSettings->broadcasterId);
        $this->assertTrue($guestStarSettings->isModeratorSendLiveEnabled);
        $this->assertSame(5, $guestStarSettings->slotCount);
        $this->assertFalse($guestStarSettings->isBrowserSourceAudioEnabled);
        $this->assertSame('TILED_LAYOUT', $guestStarSettings->groupLayout);
        $this->assertSame('token-xyz', $guestStarSettings->browserSourceToken);
    }

    #[Test]
    public function it_defaults_browser_source_token_to_empty_string(): void
    {
        $guestStarSettings = GuestStarSettings::from([
            'broadcaster_id'                   => '11111',
            'is_moderator_send_live_enabled'   => false,
            'slot_count'                       => 2,
            'is_browser_source_audio_enabled'  => true,
            'group_layout'                     => 'SCREENSHARE_LAYOUT',
        ]);

        $this->assertSame('', $guestStarSettings->browserSourceToken);
    }
}
