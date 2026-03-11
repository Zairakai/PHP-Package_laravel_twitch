<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Users;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Users\BlockedUser;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class BlockedUserTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $blockedUser = BlockedUser::from([
            'user_id'      => '55555',
            'user_login'   => 'blockeduser',
            'display_name' => 'BlockedUser',
        ]);

        $this->assertSame('55555', $blockedUser->userId);
        $this->assertSame('blockeduser', $blockedUser->userLogin);
        $this->assertSame('BlockedUser', $blockedUser->displayName);
    }
}
