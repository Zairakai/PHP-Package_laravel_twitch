<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Moderation;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Moderation\WarnedUser;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class WarnedUserTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $warnedUser = WarnedUser::from([
            'broadcaster_id' => '12345',
            'user_id'        => '11111',
            'moderator_id'   => '67890',
            'reason'         => 'Off-topic spam',
        ]);

        self::assertSame('12345', $warnedUser->broadcasterId);
        self::assertSame('11111', $warnedUser->userId);
        self::assertSame('Off-topic spam', $warnedUser->reason);
    }

    #[Test]
    public function it_handles_null_reason(): void
    {
        $warnedUser = WarnedUser::from([
            'broadcaster_id' => '12345',
            'user_id'        => '11111',
            'moderator_id'   => '67890',
        ]);

        self::assertNull($warnedUser->reason);
    }
}
