<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Moderation;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents an unban request in a broadcaster's channel.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-unban-requests
 */
#[MapInputName(SnakeCaseMapper::class)]
class UnbanRequest extends Data
{
    public function __construct(
        /**
         * @var string Unban request ID
         */
        public string $id,

        /**
         * @var string Broadcaster ID
         */
        public string $broadcasterId,

        /**
         * @var string Broadcaster login (lowercase)
         */
        public string $broadcasterLogin,

        /**
         * @var string Broadcaster display name
         */
        public string $broadcasterName,

        /**
         * @var string User ID who submitted the request
         */
        public string $userId,

        /**
         * @var string User login who submitted the request
         */
        public string $userLogin,

        /**
         * @var string User display name who submitted the request
         */
        public string $userName,

        /**
         * @var string Request message from the user
         */
        public string $text,

        /**
         * @var string Status: pending, approved, denied, acknowledged, cancelled
         */
        public string $status,

        /**
         * @var string|null When the request was created (RFC3339)
         */
        public ?string $createdAt = null,

        /**
         * @var string|null Moderator who resolved the request
         */
        public ?string $moderatorId = null,

        /**
         * @var string|null Moderator login
         */
        public ?string $moderatorLogin = null,

        /**
         * @var string|null Moderator display name
         */
        public ?string $moderatorName = null,

        /**
         * @var string|null When the request was resolved (RFC3339)
         */
        public ?string $resolvedAt = null,

        /**
         * @var string|null Resolution message from the moderator
         */
        public ?string $resolutionText = null,
    ) {}
}
