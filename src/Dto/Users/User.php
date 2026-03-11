<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Users;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a Twitch user profile.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-users
 */
#[MapInputName(SnakeCaseMapper::class)]
class User extends Data
{
    public function __construct(
        /**
         * @var string Twitch user ID
         */
        public string $id,

        /**
         * @var string User's login name (lowercase)
         */
        public string $login,

        /**
         * @var string User's display name
         */
        public string $displayName,

        /**
         * @var string User type: admin, global_mod, staff, or ''
         */
        public string $type,

        /**
         * @var string Broadcaster type: affiliate, partner, or ''
         */
        public string $broadcasterType,

        /**
         * @var string User's channel description
         */
        public string $description,

        /**
         * @var string URL of profile image (300×300)
         */
        public string $profileImageUrl,

        /**
         * @var string URL of offline banner image
         */
        public string $offlineImageUrl,

        /**
         * @var int Total number of channel views
         */
        public int $viewCount,

        /**
         * @var Carbon|null Account creation date (RFC3339)
         */
        public ?Carbon $createdAt = null,

        /**
         * @var string|null Email address (only if user:read:email scope granted)
         */
        public ?string $email = null,
    ) {}
}
