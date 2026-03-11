<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Chat;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Chat\Emote;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class EmoteTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $emote = Emote::from([
            'id'           => 'emotesv2_abc',
            'name'         => 'LUL',
            'images'       => ['url_1x' => 'https://example.com/1x.png', 'url_2x' => 'https://example.com/2x.png', 'url_4x' => 'https://example.com/4x.png'],
            'format'       => ['animated', 'static'],
            'scale'        => ['1.0', '2.0', '3.0'],
            'theme_mode'   => ['dark', 'light'],
            'emote_type'   => 'globals',
            'emote_set_id' => 'set-001',
            'tier'         => null,
        ]);

        $this->assertSame('emotesv2_abc', $emote->id);
        $this->assertSame('LUL', $emote->name);
        $this->assertSame(['animated', 'static'], $emote->format);
        $this->assertSame('globals', $emote->emoteType);
        $this->assertNull($emote->tier);
    }
}
