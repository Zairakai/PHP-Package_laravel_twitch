<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Teams;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Teams\Team;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class TeamTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $team = Team::from([
            'id'                   => 'team-001',
            'team_name'            => 'twitchrivals',
            'team_display_name'    => 'TwitchRivals',
            'info'                 => 'A competitive team.',
            'thumbnail_url'        => 'https://example.com/thumb.jpg',
            'background_image_url' => 'https://example.com/bg.jpg',
            'banner'               => 'https://example.com/banner.jpg',
            'users'                => [['user_id' => '11111', 'user_login' => 'player1']],
            'created_at'           => '2020-06-01T00:00:00Z',
            'updated_at'           => '2024-01-01T00:00:00Z',
        ]);

        $this->assertSame('team-001', $team->id);
        $this->assertSame('twitchrivals', $team->teamName);
        $this->assertSame('TwitchRivals', $team->teamDisplayName);
        $this->assertCount(1, $team->users);
        $this->assertInstanceOf(Carbon::class, $team->createdAt);
        $this->assertInstanceOf(Carbon::class, $team->updatedAt);
    }

    #[Test]
    public function it_defaults_users_to_empty_array(): void
    {
        $team = Team::from([
            'id'                   => 'team-002',
            'team_name'            => 'empty',
            'team_display_name'    => 'Empty',
            'info'                 => '',
            'thumbnail_url'        => '',
            'background_image_url' => '',
            'banner'               => '',
        ]);

        $this->assertSame([], $team->users);
        $this->assertNull($team->createdAt);
    }
}
