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

        $this->assertSame('12345', $guestStarInvite->userId);
        $this->assertSame('twitchdev', $guestStarInvite->userLogin);
        $this->assertSame('TwitchDev', $guestStarInvite->userDisplayName);
        $this->assertTrue($guestStarInvite->isVideoEnabled);
        $this->assertTrue($guestStarInvite->isAudioEnabled);
        $this->assertFalse($guestStarInvite->isModerator);
        $this->assertTrue($guestStarInvite->isGuestStarParticipant);
    }
}
