<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Polls\Requests;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Polls\Requests\CreatePollRequest;
use Zairakai\LaravelTwitch\Dto\Polls\Requests\PollChoiceRequest;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class CreatePollRequestTest extends TestCase
{
    #[Test]
    public function it_serializes_to_snake_case_for_the_api(): void
    {
        $createPollRequest = new CreatePollRequest(
            broadcasterId: '12345',
            title: 'Best game?',
            choices: [
                new PollChoiceRequest(title: 'LoL'),
                new PollChoiceRequest(title: 'Dota'),
            ],
            duration: 300,
            channelPointsVotingEnabled: true,
            channelPointsPerVote: 100,
        );

        $array = $createPollRequest->toArray();

        self::assertSame('12345', $array['broadcaster_id']);
        self::assertSame('Best game?', $array['title']);
        self::assertSame(300, $array['duration']);
        self::assertTrue($array['channel_points_voting_enabled']);
        self::assertSame(100, $array['channel_points_per_vote']);
    }
}
