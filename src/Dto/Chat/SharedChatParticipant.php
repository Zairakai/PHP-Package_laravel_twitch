<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Chat;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a participant in a shared chat session.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-shared-chat-session
 */
#[MapInputName(SnakeCaseMapper::class)]
class SharedChatParticipant extends Data
{
    public function __construct(
        /**
         * @var string Broadcaster ID of the participant
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
    ) {}
}
