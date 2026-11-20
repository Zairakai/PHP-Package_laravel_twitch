<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\GuestStar;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\GuestStar\GuestStarSession;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class GuestStarSessionTest extends TestCase
{
    #[Test]
    public function it_can_be_created_with_guests(): void
    {
        $guestStarSession = GuestStarSession::from([
            'id'     => 'session-abc',
            'guests' => [
                [
                    'user_id'    => '11111',
                    'user_login' => 'guest_one',
                ],
                [
                    'user_id'    => '22222',
                    'user_login' => 'guest_two',
                ],
            ],
        ]);

        self::assertSame('session-abc', $guestStarSession->id);
        self::assertCount(2, $guestStarSession->guests);
        self::assertSame('11111', $guestStarSession->guests[0]['user_id']);
        self::assertSame('guest_two', $guestStarSession->guests[1]['user_login']);
    }

    #[Test]
    public function it_defaults_guests_to_empty_array(): void
    {
        $guestStarSession = GuestStarSession::from([
            'id' => 'session-empty',
        ]);

        self::assertSame('session-empty', $guestStarSession->id);
        self::assertSame([], $guestStarSession->guests);
    }
}
