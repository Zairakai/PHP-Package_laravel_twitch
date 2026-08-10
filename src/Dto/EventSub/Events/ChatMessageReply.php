<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Present on a `channel.chat.message` event when the message is a reply to
 * another message - carries both the immediate parent and the root of the
 * reply thread.
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChatMessageReply extends Data
{
    public function __construct(
        public string $parentMessageId,
        public string $parentMessageBody,
        public string $parentUserId,
        public string $parentUserLogin,
        public string $parentUserName,
        public string $threadMessageId,
        public string $threadUserId,
        public string $threadUserLogin,
        public string $threadUserName,
    ) {}
}
