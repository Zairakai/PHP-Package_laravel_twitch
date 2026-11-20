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

        self::assertSame('55555', $blockedUser->userId);
        self::assertSame('blockeduser', $blockedUser->userLogin);
        self::assertSame('BlockedUser', $blockedUser->displayName);
    }
}
