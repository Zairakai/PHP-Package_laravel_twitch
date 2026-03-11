<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Channel;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Channel\SearchChannel;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class SearchChannelTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $searchChannel = SearchChannel::from([
            'id'                   => '44444',
            'display_name'         => 'LiveStreamer',
            'broadcaster_login'    => 'livestreamer',
            'broadcaster_language' => 'en',
            'game_id'              => '509658',
            'game_name'            => 'Just Chatting',
            'title'                => 'Hanging out!',
            'is_live'              => true,
            'thumbnail_url'        => 'https://example.com/thumb.jpg',
            'tags'                 => ['IRL'],
            'started_at'           => '2024-01-01T18:00:00Z',
        ]);

        $this->assertSame('44444', $searchChannel->id);
        $this->assertSame('LiveStreamer', $searchChannel->displayName);
        $this->assertTrue($searchChannel->isLive);
        $this->assertSame(['IRL'], $searchChannel->tags);
        $this->assertInstanceOf(Carbon::class, $searchChannel->startedAt);
    }

    #[Test]
    public function it_handles_offline_channel(): void
    {
        $searchChannel = SearchChannel::from([
            'id'                   => '33333',
            'display_name'         => 'OfflineUser',
            'broadcaster_login'    => 'offlineuser',
            'broadcaster_language' => 'de',
            'game_id'              => '',
            'game_name'            => '',
            'title'                => 'See you tomorrow',
            'is_live'              => false,
            'thumbnail_url'        => '',
        ]);

        $this->assertFalse($searchChannel->isLive);
        $this->assertNull($searchChannel->startedAt);
        $this->assertSame([], $searchChannel->tags);
    }
}
