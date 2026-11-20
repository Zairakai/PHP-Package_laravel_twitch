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

        self::assertSame('98765', $guestStarSettings->broadcasterId);
        self::assertTrue($guestStarSettings->isModeratorSendLiveEnabled);
        self::assertSame(5, $guestStarSettings->slotCount);
        self::assertFalse($guestStarSettings->isBrowserSourceAudioEnabled);
        self::assertSame('TILED_LAYOUT', $guestStarSettings->groupLayout);
        self::assertSame('token-xyz', $guestStarSettings->browserSourceToken);
    }

    #[Test]
    public function it_leaves_the_browser_source_token_null_for_a_caller_who_is_not_the_broadcaster(): void
    {
        $guestStarSettings = GuestStarSettings::from([
            'broadcaster_id'                   => '11111',
            'is_moderator_send_live_enabled'   => false,
            'slot_count'                       => 2,
            'is_browser_source_audio_enabled'  => true,
            'group_layout'                     => 'SCREENSHARE',
        ]);

        // Twitch gives the token to the broadcaster only (null otherwise).
        self::assertNull($guestStarSettings->browserSourceToken);
    }
}
