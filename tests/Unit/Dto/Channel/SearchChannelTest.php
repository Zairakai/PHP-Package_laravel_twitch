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
            'tags'                 => [
                'IRL',
            ],
            'started_at'           => '2024-01-01T18:00:00Z',
        ]);

        self::assertSame('44444', $searchChannel->id);
        self::assertSame('LiveStreamer', $searchChannel->displayName);
        self::assertTrue($searchChannel->isLive);
        self::assertSame([
            'IRL',
        ], $searchChannel->tags);
        self::assertInstanceOf(Carbon::class, $searchChannel->startedAt);
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

        self::assertFalse($searchChannel->isLive);
        self::assertNull($searchChannel->startedAt);
        self::assertSame([], $searchChannel->tags);
    }

    #[Test]
    public function it_reads_an_empty_started_at_as_null(): void
    {
        // The real API sends "" (not null) for an offline channel: the DTO used to throw CannotCastDate.
        $searchChannel = SearchChannel::from([
            'id'                   => '44444',
            'display_name'         => 'Offline',
            'broadcaster_login'    => 'offline',
            'broadcaster_language' => 'en',
            'game_id'              => '',
            'game_name'            => '',
            'title'                => '',
            'is_live'              => false,
            'thumbnail_url'        => '',
            'started_at'           => '',
        ]);

        self::assertNull($searchChannel->startedAt);
    }
}
