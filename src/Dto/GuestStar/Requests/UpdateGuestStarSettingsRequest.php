<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\GuestStar\Requests;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Request DTO for updating Guest Star channel settings.
 *
 * All fields are optional — only non-null fields are sent to the API.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#update-channel-guest-star-settings
 */
#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class UpdateGuestStarSettingsRequest extends TwitchData
{
    public function __construct(
        /**
         * @var bool|null Whether a moderator can send a guest live
         */
        public readonly ?bool $isModeratorSendLiveEnabled = null,

        /**
         * @var int|null Number of available guest slots (1-6)
         */
        public readonly ?int $slotCount = null,

        /**
         * @var bool|null Whether browser source audio is shared to guests
         */
        public readonly ?bool $isBrowserSourceAudioEnabled = null,

        /**
         * @var string|null Layout: TILED or SCREENSHARE
         */
        public readonly ?string $groupLayout = null,

        /**
         * @var string|null Not in the current Twitch API reference: never sent (kept so that existing calls still compile)
         *
         * @deprecated Twitch no longer documents this setting
         */
        public readonly ?string $broadcasterAudioSetting = null,

        /**
         * @var bool|null Whether to regenerate browser sources
         */
        public readonly ?bool $regenerateBrowserSources = null,
    ) {}
}
