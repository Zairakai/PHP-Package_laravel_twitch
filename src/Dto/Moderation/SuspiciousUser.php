<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Moderation;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a suspicious or restricted user in a broadcaster's channel.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#manage-held-automod-messages
 */
#[MapInputName(SnakeCaseMapper::class)]
class SuspiciousUser extends Data
{
    public function __construct(
        /**
         * @var string Broadcaster ID
         */
        public string $broadcasterId,

        /**
         * @var string Moderator ID who managed the user
         */
        public string $moderatorId,

        /**
         * @var string User ID
         */
        public string $userId,

        /**
         * @var string User login (lowercase)
         */
        public string $userLogin,

        /**
         * @var string User display name
         */
        public string $userName,

        /**
         * @var string Status: active_monitoring or restricted
         */
        public string $lowTrustStatus,

        /**
         * @var array<string> Types: ban_evader_detector, manually_added
         */
        public array $types = [],

        /**
         * @var array<string> Channel IDs where the user is shared-banned
         */
        public array $sharedBanChannelIds = [],

        /**
         * @var string Ban evasion evaluation: unknown, possible, likely
         */
        public string $banEvasionEvaluation = 'unknown',

        /**
         * @var string|null When the status was created (RFC3339)
         */
        public ?string $createdAt = null,

        /**
         * @var string|null When the status was last updated (RFC3339)
         */
        public ?string $updatedAt = null,
    ) {}
}
