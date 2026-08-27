<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\Chat\Structures\Message;

/**
 * Payload of a `channel.bits.use` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-13.
 * `powerUp` and `customPowerUp` are left as raw arrays (only populated when
 * `type` is `power_up`/`custom_power_up`, null for the far more common
 * `cheer` case) - their exact nested shape is not published in the official
 * example payloads, same convention already used by
 * ChannelCustomPowerUpRedemptionAddEvent::$customPowerUp rather than
 * guessing a wrong nested DTO.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelbitsuse
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelBitsUseEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $userId,
        public string $userLogin,
        public string $userName,
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public int $bits,

        /**
         * @var string cheer, power_up or custom_power_up
         */
        public string $type,

        /**
         * @var array<string, mixed>|null
         */
        public ?array $powerUp,

        /**
         * @var array<string, mixed>|null
         */
        public ?array $customPowerUp,
        public ?Message $message = null,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->broadcasterUserId;
    }
}
