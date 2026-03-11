<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Moderation;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents the result of issuing a warning to a user.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#warn-chat-user
 */
#[MapInputName(SnakeCaseMapper::class)]
class WarnedUser extends Data
{
    public function __construct(
        /**
         * @var string Broadcaster ID
         */
        public string $broadcasterId,

        /**
         * @var string Warned user ID
         */
        public string $userId,

        /**
         * @var string Moderator who issued the warning
         */
        public string $moderatorId,

        /**
         * @var string|null Reason for the warning
         */
        public ?string $reason = null,
    ) {}
}
