<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Users;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Users\Follower;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class FollowerTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $follower = Follower::from([
            'user_id'     => '99999',
            'user_login'  => 'followeruser',
            'user_name'   => 'FollowerUser',
            'followed_at' => '2023-03-15T10:00:00Z',
        ]);

        $this->assertSame('99999', $follower->userId);
        $this->assertSame('followeruser', $follower->userLogin);
        $this->assertInstanceOf(Carbon::class, $follower->followedAt);
    }
}
