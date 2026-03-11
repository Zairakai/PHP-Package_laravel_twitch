<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Chat\Structures;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Chat\Structures\Message;
use Zairakai\LaravelTwitch\Dto\Chat\Structures\MessageFragment;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class MessageTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $message = Message::from([
            'text'      => 'Hello world Cheer100',
            'fragments' => [
                ['type' => 'text', 'text' => 'Hello world ', 'cheermote' => null, 'emote' => null, 'mention' => null],
                ['type' => 'cheermote', 'text' => 'Cheer100', 'cheermote' => ['prefix' => 'Cheer', 'bits' => 100, 'tier' => 1], 'emote' => null, 'mention' => null],
            ],
        ]);

        $this->assertSame('Hello world Cheer100', $message->text);
        $this->assertCount(2, $message->fragments);
        $this->assertInstanceOf(MessageFragment::class, $message->fragments->first());
    }
}
