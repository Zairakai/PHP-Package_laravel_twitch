<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Channel;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Channel\ChannelEditor;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class ChannelEditorTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $channelEditor = ChannelEditor::from([
            'user_id'    => '55555',
            'user_name'  => 'EditorUser',
            'created_at' => '2023-01-15T10:00:00Z',
        ]);

        $this->assertSame('55555', $channelEditor->userId);
        $this->assertSame('EditorUser', $channelEditor->userName);
        $this->assertInstanceOf(Carbon::class, $channelEditor->createdAt);
    }

    #[Test]
    public function it_handles_null_created_at(): void
    {
        $channelEditor = ChannelEditor::from([
            'user_id'   => '55555',
            'user_name' => 'EditorUser',
        ]);

        $this->assertNull($channelEditor->createdAt);
    }
}
