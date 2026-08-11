<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `automod.settings.update` EventSub notification.
 *
 * Unlike every other EventSub type, Twitch's own official example wraps this
 * event's fields in a single-item `data` array (verified verbatim against the
 * docs on 2026-08-09, not an extraction artifact) - kept as-is to match the
 * documented contract rather than silently reshaping it.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#automodsettingsupdate
 */
#[MapInputName(SnakeCaseMapper::class)]
class AutomodSettingsUpdateEvent extends Data implements EventSubEvent
{
    public function __construct(
        /**
         * @var array<int, array<string, mixed>> Single-item list containing the settings object
         */
        public array $data,
    ) {}

    public function getBroadcasterUserId(): ?string
    {
        $settings = $this->data[0] ?? null;

        if (! is_array($settings)) {
            return null;
        }

        $broadcasterUserId = $settings['broadcaster_user_id'] ?? null;

        return is_string($broadcasterUserId) ? $broadcasterUserId : null;
    }
}
