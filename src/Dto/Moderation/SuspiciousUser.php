<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Moderation;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents a suspicious or restricted user in a broadcaster's channel.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#manage-held-automod-messages
 */
#[MapInputName(SnakeCaseMapper::class)]
class SuspiciousUser extends TwitchData
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
         * @var string|null User login (lowercase). Not sent by Add Suspicious Status.
         */
        public ?string $userLogin = null,

        /**
         * @var string|null User display name. Not sent by Add Suspicious Status.
         */
        public ?string $userName = null,

        /**
         * @var string|null Status as the EventSub notifications give it: active_monitoring or restricted
         */
        public ?string $lowTrustStatus = null,

        /**
         * @var string|null Status as Add / Remove Suspicious Status give it: ACTIVE_MONITORING, RESTRICTED or NO_TREATMENT
         */
        public ?string $status = null,

        /**
         * @var array<string> Types: MANUALLY_ADDED, DETECTED_BAN_EVADER, DETECTED_SUS_CHATTER, BANNED_IN_SHARED_CHANNEL, UNKNOWN_TYPE
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
