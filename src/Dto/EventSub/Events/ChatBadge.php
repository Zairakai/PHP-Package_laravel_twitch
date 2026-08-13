<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * A single badge attached to a chat message (`{set_id, id, info}`).
 *
 * Distinct from `Dto\Chat\Badge` (the Helix "Get Channel Chat Badges" API
 * shape - a badge *set* with a `versions` array) - this is the smaller,
 * per-user-per-message shape EventSub embeds inline in chat payloads.
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChatBadge extends Data
{
    public function __construct(
        public string $setId,
        public string $id,
        // Twitch sends null for most badges (only a handful, e.g. subscriber
        // tier, actually populate this field) - was typed non-nullable string,
        // rejecting the majority of real chat message payloads outright.
        public ?string $info = null,
    ) {}
}
