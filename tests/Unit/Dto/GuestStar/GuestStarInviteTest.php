<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\GuestStar;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\GuestStar\GuestStarInvite;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class GuestStarInviteTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $guestStarInvite = GuestStarInvite::from([
            'user_id'                   => '12345',
            'user_login'                => 'twitchdev',
            'user_display_name'         => 'TwitchDev',
            'is_video_enabled'          => true,
            'is_audio_enabled'          => true,
            'is_moderator'              => false,
            'is_guest_star_participant' => true,
        ]);

        self::assertSame('12345', $guestStarInvite->userId);
        self::assertSame('twitchdev', $guestStarInvite->userLogin);
        self::assertSame('TwitchDev', $guestStarInvite->userDisplayName);
        self::assertTrue($guestStarInvite->isVideoEnabled);
        self::assertTrue($guestStarInvite->isAudioEnabled);
        self::assertFalse($guestStarInvite->isModerator);
        self::assertTrue($guestStarInvite->isGuestStarParticipant);
    }
}
