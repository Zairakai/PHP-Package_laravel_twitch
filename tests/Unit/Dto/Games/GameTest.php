<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Games;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Games\Game;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class GameTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $game = Game::from([
            'id'          => '21779',
            'name'        => 'League of Legends',
            'box_art_url' => 'https://static-cdn.jtvnw.net/ttv-boxart/21779-{width}x{height}.jpg',
            'igdb_id'     => '115',
        ]);

        $this->assertSame('21779', $game->id);
        $this->assertSame('League of Legends', $game->name);
        $this->assertSame('115', $game->igdbId);
    }

    #[Test]
    public function it_handles_null_igdb_id(): void
    {
        $game = Game::from([
            'id'          => '509658',
            'name'        => 'Just Chatting',
            'box_art_url' => 'https://static-cdn.jtvnw.net/ttv-boxart/509658-{width}x{height}.jpg',
        ]);

        $this->assertNull($game->igdbId);
    }
}
