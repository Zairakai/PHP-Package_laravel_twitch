<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Chat;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Chat\SharedChatSession;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class SharedChatSessionTest extends TestCase
{
    #[Test]
    public function it_can_be_created_with_participants(): void
    {
        $sharedChatSession = SharedChatSession::from([
            'session_id'              => 'session-abc',
            'host_broadcaster_id'     => '12345',
            'host_broadcaster_login'  => 'twitchdev',
            'host_broadcaster_name'   => 'TwitchDev',
            'participants'            => [
                ['broadcaster_id' => '11111', 'broadcaster_login' => 'p1', 'broadcaster_name' => 'P1'],
            ],
        ]);

        $this->assertSame('session-abc', $sharedChatSession->sessionId);
        $this->assertSame('12345', $sharedChatSession->hostBroadcasterId);
        $this->assertCount(1, $sharedChatSession->participants);
    }

    #[Test]
    public function it_defaults_participants_to_empty_array(): void
    {
        $sharedChatSession = SharedChatSession::from([
            'session_id'             => 'session-xyz',
            'host_broadcaster_id'    => '12345',
            'host_broadcaster_login' => 'twitchdev',
            'host_broadcaster_name'  => 'TwitchDev',
        ]);

        $this->assertSame([], $sharedChatSession->participants);
    }
}
