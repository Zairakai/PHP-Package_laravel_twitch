<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\EventSub\Events;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChatBadge;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class ChatBadgeTest extends TestCase
{
    #[Test]
    public function it_accepts_a_null_info_field(): void
    {
        // Twitch sends null for most real badges (only a handful, e.g.
        // subscriber tier, actually populate this field) - was typed
        // non-nullable string, crashing on the majority of real
        // channel.chat.message payloads.
        $chatBadge = ChatBadge::from([
            'set_id' => 'moderator',
            'id'     => '1',
            'info'   => null,
        ]);

        $this->assertSame('moderator', $chatBadge->setId);
        $this->assertSame('1', $chatBadge->id);
        $this->assertNull($chatBadge->info);
    }

    #[Test]
    public function it_accepts_a_populated_info_field(): void
    {
        $chatBadge = ChatBadge::from([
            'set_id' => 'subscriber',
            'id'     => '12',
            'info'   => '16',
        ]);

        $this->assertSame('16', $chatBadge->info);
    }
}
