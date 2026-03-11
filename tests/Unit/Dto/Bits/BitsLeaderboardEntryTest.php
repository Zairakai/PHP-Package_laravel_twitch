<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Bits;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Bits\BitsLeaderboardEntry;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class BitsLeaderboardEntryTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $bitsLeaderboardEntry = BitsLeaderboardEntry::from([
            'user_id'    => '12345',
            'user_login' => 'twitchdev',
            'user_name'  => 'TwitchDev',
            'score'      => 12500,
            'rank'       => 1,
        ]);

        $this->assertSame('12345', $bitsLeaderboardEntry->userId);
        $this->assertSame('twitchdev', $bitsLeaderboardEntry->userLogin);
        $this->assertSame('TwitchDev', $bitsLeaderboardEntry->userName);
        $this->assertSame(12500, $bitsLeaderboardEntry->score);
        $this->assertSame(1, $bitsLeaderboardEntry->rank);
    }
}
