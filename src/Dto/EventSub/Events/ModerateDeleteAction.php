<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * `channel.moderate` payload when `action` is `delete`. Reused for
 * `shared_chat_delete`.
 *
 * Shape inferred from Twitch's documented EventSub schema, not
 * independently re-verified against a fetched example - double check
 * before relying on it in production.
 */
#[MapInputName(SnakeCaseMapper::class)]
class ModerateDeleteAction extends Data
{
    public function __construct(
        public string $userId,
        public string $userLogin,
        public string $userName,
        public string $messageId,
        public string $messageBody,
    ) {}
}
