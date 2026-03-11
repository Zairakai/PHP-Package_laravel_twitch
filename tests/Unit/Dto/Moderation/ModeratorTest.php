<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Moderation;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Moderation\Moderator;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class ModeratorTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $moderator = Moderator::from([
            'user_id'    => '67890',
            'user_login' => 'moduser',
            'user_name'  => 'ModUser',
        ]);

        $this->assertSame('67890', $moderator->userId);
        $this->assertSame('moduser', $moderator->userLogin);
        $this->assertSame('ModUser', $moderator->userName);
    }
}
