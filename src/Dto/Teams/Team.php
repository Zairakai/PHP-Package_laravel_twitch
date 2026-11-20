<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Teams;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents a Twitch team.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-teams
 */
#[MapInputName(SnakeCaseMapper::class)]
class Team extends TwitchData
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
         * @var string|null URL to team thumbnail (null when the team has none)
         */
        public ?string $thumbnailUrl,

        /**
         * @var string|null URL to team background image (null when the team has none)
         */
        public ?string $backgroundImageUrl,

        /**
         * @var string|null URL to team banner (null when the team has none)
         */
        public ?string $banner,

        /**
         * @var list<array{user_id: string, user_name: string, user_login: string}> Team members
         */
        public array $users = [],

        /**
         * @var Carbon|null When the team was created
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $createdAt = null,

        /**
         * @var Carbon|null When the team was last updated
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $updatedAt = null,

        /**
         * @var string|null Broadcaster ID (Get Channel Teams only)
         */
        public ?string $broadcasterId = null,

        /**
         * @var string|null Broadcaster login (Get Channel Teams only)
         */
        public ?string $broadcasterLogin = null,

        /**
         * @var string|null Broadcaster display name (Get Channel Teams only)
         */
        public ?string $broadcasterName = null,
    ) {}
}
