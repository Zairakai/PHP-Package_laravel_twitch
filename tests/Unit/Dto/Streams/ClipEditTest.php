<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Streams;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Streams\ClipEdit;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class ClipEditTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $clipEdit = ClipEdit::from([
            'id'       => 'AwkwardHelp',
            'edit_url' => 'https://clips.twitch.tv/AwkwardHelp/edit',
        ]);

        $this->assertSame('AwkwardHelp', $clipEdit->id);
        $this->assertSame('https://clips.twitch.tv/AwkwardHelp/edit', $clipEdit->editUrl);
    }
}
