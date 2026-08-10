<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * `channel.moderate` payload when `action` is `ban` (permanent, no expiry -
 * see ModerateTimeoutAction for the temporary variant). Reused for
 * `shared_chat_ban`.
 *
 * Shape inferred from Twitch's documented EventSub schema, not
 * independently re-verified against a fetched example (the single captured
 * reference payload only populated the `mod` action) - double check before
 * relying on it in production.
 */
#[MapInputName(SnakeCaseMapper::class)]
class ModerateBanAction extends Data
{
    public function __construct(
        public string $userId,
        public string $userLogin,
        public string $userName,
        public string $reason,
    ) {}
}
