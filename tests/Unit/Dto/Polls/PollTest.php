<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Polls;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Polls\Poll;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class PollTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $poll = Poll::from([
            'id'                            => 'poll-001',
            'broadcaster_id'                => '12345',
            'broadcaster_login'             => 'twitchdev',
            'broadcaster_name'              => 'TwitchDev',
            'title'                         => 'Best game?',
            'status'                        => 'ACTIVE',
            'duration'                      => 300,
            'channel_points_voting_enabled' => true,
            'channel_points_per_vote'       => 100,
            'choices'                       => [
                ['id' => 'c1', 'title' => 'LoL', 'votes' => 50, 'channel_points_votes' => 2000],
                ['id' => 'c2', 'title' => 'Dota', 'votes' => 30, 'channel_points_votes' => 1000],
            ],
            'started_at' => '2024-03-01T10:00:00Z',
        ]);

        $this->assertSame('poll-001', $poll->id);
        $this->assertSame('ACTIVE', $poll->status);
        $this->assertSame(300, $poll->duration);
        $this->assertTrue($poll->channelPointsVotingEnabled);
        $this->assertCount(2, $poll->choices);
        $this->assertInstanceOf(Carbon::class, $poll->startedAt);
        $this->assertNull($poll->endedAt);
    }
}
