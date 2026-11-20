<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\GuestStar\Requests;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Request DTO for updating Guest Star slot settings.
 *
 * All fields are optional — only non-null fields are sent to the API.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#update-guest-star-slot-settings
 */
#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class UpdateGuestStarSlotSettingsRequest extends TwitchData
{
    public function __construct(
        /**
         * @var bool|null Whether the guest's audio is enabled
         */
        public readonly ?bool $isAudioEnabled = null,

        /**
         * @var bool|null Whether the guest's video is enabled
         */
        public readonly ?bool $isVideoEnabled = null,

        /**
         * @var bool|null Whether the slot is marked as live
         */
        public readonly ?bool $isLive = null,

        /**
         * @var int|null Guest volume level (0-100). Not supported by Twitch any more: never sent.
         *
         * @deprecated Removed from the Twitch API reference
         */
        public readonly ?int $volume = null,
    ) {}
}
