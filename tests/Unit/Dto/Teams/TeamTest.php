<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Teams;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Teams\Team;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class TeamTest extends TestCase
{
    #[Test]
    public function it_accepts_a_team_without_images(): void
    {
        // The real API answers null for these fields (a team without banner): the DTO used to throw a TypeError.
        $team = Team::from([
            'id'                   => '6',
            'team_name'            => 'staff',
            'team_display_name'    => 'Staff',
            'info'                 => 'The team',
            'thumbnail_url'        => null,
            'background_image_url' => null,
            'banner'               => null,
            'created_at'           => null,
            'updated_at'           => null,
        ]);

        self::assertNull($team->thumbnailUrl);
        self::assertNull($team->backgroundImageUrl);
        self::assertNull($team->banner);
        self::assertNull($team->createdAt);
    }
}
