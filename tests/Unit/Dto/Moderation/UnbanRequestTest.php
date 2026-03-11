<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Moderation;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Moderation\UnbanRequest;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class UnbanRequestTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $unbanRequest = UnbanRequest::from([
            'id'                => 'req-001',
            'broadcaster_id'    => '12345',
            'broadcaster_login' => 'twitchdev',
            'broadcaster_name'  => 'TwitchDev',
            'user_id'           => '11111',
            'user_login'        => 'banneduser',
            'user_name'         => 'BannedUser',
            'text'              => 'I promise I will follow the rules.',
            'status'            => 'pending',
            'created_at'        => '2024-01-01T00:00:00Z',
        ]);

        $this->assertSame('req-001', $unbanRequest->id);
        $this->assertSame('pending', $unbanRequest->status);
        $this->assertSame('I promise I will follow the rules.', $unbanRequest->text);
        $this->assertSame('2024-01-01T00:00:00Z', $unbanRequest->createdAt);
        $this->assertNull($unbanRequest->moderatorId);
        $this->assertNull($unbanRequest->resolvedAt);
    }
}
