<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Teams;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a Twitch team.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-teams
 */
#[MapInputName(SnakeCaseMapper::class)]
class Team extends Data
{
    public function __construct(
        /**
         * @var string Team ID
         */
        public string $id,

        /**
         * @var string Team name (slug)
         */
        public string $teamName,

        /**
         * @var string Team display name
         */
        public string $teamDisplayName,

        /**
         * @var string Team description/info
         */
        public string $info,

        /**
         * @var string URL to team thumbnail
         */
        public string $thumbnailUrl,

        /**
         * @var string URL to team background image
         */
        public string $backgroundImageUrl,

        /**
         * @var string URL to team banner
         */
        public string $banner,

        /**
         * @var list<array{user_id: string, user_name: string, user_login: string}> Team members
         */
        public array $users = [],

        /**
         * @var Carbon|null When the team was created
         */
        public ?Carbon $createdAt = null,

        /**
         * @var Carbon|null When the team was last updated
         */
        public ?Carbon $updatedAt = null,
    ) {}
}
