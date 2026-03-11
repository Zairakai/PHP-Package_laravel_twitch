<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Chat;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Chat\SentMessage;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class SentMessageTest extends TestCase
{
    #[Test]
    public function it_can_be_created_for_sent_message(): void
    {
        $sentMessage = SentMessage::from([
            'message_id' => 'msg-abc',
            'is_sent'    => true,
        ]);

        $this->assertSame('msg-abc', $sentMessage->messageId);
        $this->assertTrue($sentMessage->isSent);
        $this->assertNull($sentMessage->dropReason);
    }

    #[Test]
    public function it_can_be_created_with_drop_reason(): void
    {
        $sentMessage = SentMessage::from([
            'message_id'  => 'msg-xyz',
            'is_sent'     => false,
            'drop_reason' => ['code' => 'channel_settings_blocked', 'message' => 'Blocked by channel settings.', 'user_id' => '99999'],
        ]);

        $this->assertFalse($sentMessage->isSent);
        $this->assertSame('channel_settings_blocked', $sentMessage->dropReason['code']);
    }
}
