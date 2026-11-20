<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Chat\Structures;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Chat\Structures\MentionFragment;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class MentionFragmentTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $mentionFragment = MentionFragment::from([
            'user_id'    => '12345',
            'user_login' => 'zairakai',
            'user_name'  => 'Zairakai',
        ]);

        self::assertSame('12345', $mentionFragment->userId);
        self::assertSame('zairakai', $mentionFragment->userLogin);
        self::assertSame('Zairakai', $mentionFragment->userName);
    }
}
