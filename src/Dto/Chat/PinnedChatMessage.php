<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Chat;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\Chat\Structures\Message;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;

/**
 * Represents the broadcaster's currently mod-pinned chat message. At most
 * one can be active per channel.
 *
 * Confirmed verbatim against Twitch's own docs (2026-08-27) - GET
 * /helix/chat/pins. `endsAt` is null when the message is pinned until the
 * stream ends rather than for a fixed duration.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-pinned-chat-message
 */
#[MapInputName(SnakeCaseMapper::class)]
class PinnedChatMessage extends Data
{
    public function __construct(
        public string $messageId,
        public string $broadcasterId,
        public string $senderUserId,
        public string $senderUserLogin,
        public string $senderUserName,
        public string $pinnedByUserId,
        public string $pinnedByUserLogin,
        public string $pinnedByUserName,
        public Message $message,
        #[WithCast(FlexibleDateTimeCast::class)]
        public Carbon $startsAt,
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $endsAt,
        #[WithCast(FlexibleDateTimeCast::class)]
        public Carbon $updatedAt,
    ) {}
}
