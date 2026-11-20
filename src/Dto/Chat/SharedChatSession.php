<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Chat;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents an active shared chat session.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-shared-chat-session
 */
#[MapInputName(SnakeCaseMapper::class)]
class SharedChatSession extends TwitchData
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
         * @var list<array<string, mixed>> Participants in the session (broadcaster_id)
         */
        public array $participants = [],

        /**
         * @var Carbon|null When the session started
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $createdAt = null,

        /**
         * @var Carbon|null When the session was last updated
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $updatedAt = null,

        /**
         * @var string|null Not sent by Twitch (only the host ID is)
         */
        public ?string $hostBroadcasterLogin = null,

        /**
         * @var string|null Not sent by Twitch (only the host ID is)
         */
        public ?string $hostBroadcasterName = null,
    ) {}
}
