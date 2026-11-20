<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Chat\Structures;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Chat\Structures\GifFragment;
use Zairakai\LaravelTwitch\Dto\Chat\Structures\MessageFragment;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class GifFragmentTest extends TestCase
{
    #[Test]
    public function it_leaves_the_gif_empty_for_a_text_fragment(): void
    {
        $messageFragment = MessageFragment::from([
            'type'      => 'text',
            'text'      => 'hello',
            'cheermote' => null,
            'emote'     => null,
            'mention'   => null,
        ]);

        self::assertNull($messageFragment->gif);
    }

    #[Test]
    public function it_reads_a_gif_fragment(): void
    {
        $messageFragment = MessageFragment::from([
            'type'      => 'gif',
            'text'      => '',
            'cheermote' => null,
            'emote'     => null,
            'mention'   => null,
            'gif'       => [
                'id'  => 'gif-1',
                'url' => 'https://example.com/gif-1.gif',
            ],
        ]);

        self::assertSame('gif', $messageFragment->type);
        self::assertInstanceOf(GifFragment::class, $messageFragment->gif);
        self::assertSame('https://example.com/gif-1.gif', $messageFragment->gif->url);
    }
}
