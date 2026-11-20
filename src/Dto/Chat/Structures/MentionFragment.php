<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Chat\Structures;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents a user mention fragment within a chat message.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelchatmessage
 */
#[MapInputName(SnakeCaseMapper::class)]
class MentionFragment extends TwitchData
{
    public function __construct(
        /**
         * @var string Mentioned user ID
         */
        public string $userId,

        /**
         * @var string Mentioned user login (lowercase)
         */
        public string $userLogin,

        /**
         * @var string Mentioned user display name
         */
        public string $userName,
    ) {}
}
