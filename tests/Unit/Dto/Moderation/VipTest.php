<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Moderation;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Moderation\Vip;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class VipTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $vip = Vip::from([
            'user_id'    => '33333',
            'user_login' => 'vipuser',
            'user_name'  => 'VipUser',
        ]);

        self::assertSame('33333', $vip->userId);
        self::assertSame('vipuser', $vip->userLogin);
        self::assertSame('VipUser', $vip->userName);
    }
}
