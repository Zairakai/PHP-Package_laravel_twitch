<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Chat;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents the result of sending a chat message.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#send-chat-message
 */
#[MapInputName(SnakeCaseMapper::class)]
class SentMessage extends Data
{
    public function __construct(
        /**
         * @var string ID of the message that was sent
         */
        public string $messageId,

        /**
         * @var bool Whether the message was sent
         */
        public bool $isSent,

        /**
         * @var array{code: string, message: string, user_id: string}|null Reason message was dropped (null if sent)
         */
        public ?array $dropReason = null,
    ) {}
}
