<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Chat;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents an active shared chat session.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-shared-chat-session
 */
#[MapInputName(SnakeCaseMapper::class)]
class SharedChatSession extends Data
{
    public function __construct(
        /**
         * @var string Shared chat session ID
         */
        public string $sessionId,

        /**
         * @var string Host broadcaster ID
         */
        public string $hostBroadcasterId,

        /**
         * @var string Host broadcaster login (lowercase)
         */
        public string $hostBroadcasterLogin,

        /**
         * @var string Host broadcaster display name
         */
        public string $hostBroadcasterName,

        /**
         * @var list<array<string, mixed>> Participants in the session
         */
        public array $participants = [],
    ) {}
}
