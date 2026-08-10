<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * `channel.chat.notification` payload when `notice_type` is `raid`.
 *
 * Distinct from ModerateRaidAction (`channel.moderate`'s shape) - this one
 * additionally carries `profile_image_url`.
 *
 * Shape inferred from Twitch's documented EventSub schema, not
 * independently re-verified against a fetched example - double check
 * before relying on it in production.
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChatNotificationRaid extends Data
{
    public function __construct(
        public string $userId,
        public string $userLogin,
        public string $userName,
        public int $viewerCount,
        public string $profileImageUrl,
    ) {}
}
