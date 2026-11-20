<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Chat\Structures;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Chat\Structures\EmoteFragment;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class EmoteFragmentTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $emoteFragment = EmoteFragment::from([
            'id'           => 'emotesv2_abc123',
            'emote_set_id' => 'set-456',
            'owner_id'     => 'broadcaster-789',
            'format'       => [
                'animated',
                'static',
            ],
        ]);

        self::assertSame('emotesv2_abc123', $emoteFragment->id);
        self::assertSame('set-456', $emoteFragment->emoteSetId);
        self::assertSame('broadcaster-789', $emoteFragment->ownerId);
        self::assertSame([
            'animated',
            'static',
        ], $emoteFragment->format);
    }
}
