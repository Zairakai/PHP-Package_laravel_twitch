<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Chat;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Chat\Chatter;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class ChatterTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $chatter = Chatter::from([
            'user_id'    => '77777',
            'user_login' => 'chatuser',
            'user_name'  => 'ChatUser',
        ]);

        self::assertSame('77777', $chatter->userId);
        self::assertSame('chatuser', $chatter->userLogin);
        self::assertSame('ChatUser', $chatter->userName);
    }
}
