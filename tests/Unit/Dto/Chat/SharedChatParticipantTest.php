<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Chat;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Chat\SharedChatParticipant;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class SharedChatParticipantTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $sharedChatParticipant = SharedChatParticipant::from([
            'broadcaster_id'    => '11111',
            'broadcaster_login' => 'partner_channel',
            'broadcaster_name'  => 'PartnerChannel',
        ]);

        self::assertSame('11111', $sharedChatParticipant->broadcasterId);
        self::assertSame('partner_channel', $sharedChatParticipant->broadcasterLogin);
        self::assertSame('PartnerChannel', $sharedChatParticipant->broadcasterName);
    }
}
