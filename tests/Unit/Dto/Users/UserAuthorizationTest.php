<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Users;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Users\UserAuthorization;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class UserAuthorizationTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $userAuthorization = UserAuthorization::from([
            'user_id'        => '1234',
            'user_name'      => 'SomeUser',
            'user_login'     => 'someuser',
            'scopes'         => ['user:read:email', 'channel:read:subscriptions'],
            'has_authorized' => true,
        ]);

        $this->assertSame('1234', $userAuthorization->userId);
        $this->assertSame('SomeUser', $userAuthorization->userName);
        $this->assertSame('someuser', $userAuthorization->userLogin);
        $this->assertSame(['user:read:email', 'channel:read:subscriptions'], $userAuthorization->scopes);
        $this->assertTrue($userAuthorization->hasAuthorized);
    }
}
