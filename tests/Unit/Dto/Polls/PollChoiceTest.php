<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Polls;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Polls\PollChoice;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class PollChoiceTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $pollChoice = PollChoice::from([
            'id'                   => 'choice-001',
            'title'                => 'Yes',
            'votes'                => 120,
            'channel_points_votes' => 5000,
        ]);

        $this->assertSame('choice-001', $pollChoice->id);
        $this->assertSame('Yes', $pollChoice->title);
        $this->assertSame(120, $pollChoice->votes);
        $this->assertSame(5000, $pollChoice->channelPointsVotes);
    }
}
