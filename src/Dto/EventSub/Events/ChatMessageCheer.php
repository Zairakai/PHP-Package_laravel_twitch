<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Present on a `channel.chat.message` event when the message included a cheer.
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChatMessageCheer extends TwitchData
{
    public function __construct(
        public int $bits,
    ) {}
}
