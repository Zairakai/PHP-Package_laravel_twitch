<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Moderation;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Moderation\BannedUser;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class BannedUserTest extends TestCase
{
    #[Test]
    public function it_can_be_created_for_temporary_ban(): void
    {
        $bannedUser = BannedUser::from([
            'user_id'          => '11111',
            'user_login'       => 'baduser',
            'user_name'        => 'BadUser',
            'moderator_id'     => '22222',
            'moderator_login'  => 'moduser',
            'moderator_name'   => 'ModUser',
            'reason'           => 'Spam',
            'created_at'       => '2024-01-01T00:00:00Z',
            'expires_at'       => '2024-01-08T00:00:00Z',
        ]);

        $this->assertSame('11111', $bannedUser->userId);
        $this->assertSame('Spam', $bannedUser->reason);
        $this->assertInstanceOf(Carbon::class, $bannedUser->createdAt);
        $this->assertInstanceOf(Carbon::class, $bannedUser->expiresAt);
    }

    #[Test]
    public function it_handles_permanent_ban(): void
    {
        $bannedUser = BannedUser::from([
            'user_id'         => '11111',
            'user_login'      => 'baduser',
            'user_name'       => 'BadUser',
            'moderator_id'    => '22222',
            'moderator_login' => 'moduser',
            'moderator_name'  => 'ModUser',
            'reason'          => 'Hate speech',
        ]);

        $this->assertNull($bannedUser->expiresAt);
    }
}
