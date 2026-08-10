<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Bare user identity `{user_id, user_login, user_name}` - Twitch's simplest
 * reusable shape, reused verbatim across many EventSub payloads (verified
 * against `channel.moderate`'s `mod` field).
 *
 * Not to be confused with `Dto\Users\User` (the full Helix API user object)
 * or `Dto\Users\Follower` - this is deliberately the minimal identity triplet
 * Twitch embeds inline in notification payloads, nothing more.
 */
#[MapInputName(SnakeCaseMapper::class)]
class EventSubUserReference extends Data
{
    public function __construct(
        public string $userId,
        public string $userLogin,
        public string $userName,
    ) {}
}
