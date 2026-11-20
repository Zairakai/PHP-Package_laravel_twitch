<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Chat;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Chat\ChatColor;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class ChatColorTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $chatColor = ChatColor::from([
            'user_id'    => '12345',
            'user_login' => 'twitchdev',
            'user_name'  => 'TwitchDev',
            'color'      => '#FF4500',
        ]);

        self::assertSame('12345', $chatColor->userId);
        self::assertSame('twitchdev', $chatColor->userLogin);
        self::assertSame('TwitchDev', $chatColor->userName);
        self::assertSame('#FF4500', $chatColor->color);
    }
}
