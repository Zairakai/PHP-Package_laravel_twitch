<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\GuestStar;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents the Guest Star settings for a broadcaster's channel.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-channel-guest-star-settings
 */
#[MapInputName(SnakeCaseMapper::class)]
class GuestStarSettings extends TwitchData
{
    public function __construct(
        /**
         * @var bool Whether moderators can send guests live
         */
        public bool $isModeratorSendLiveEnabled,

        /**
         * @var int Number of available guest slots (1-6)
         */
        public int $slotCount,

        /**
         * @var bool Whether browser source audio is enabled
         */
        public bool $isBrowserSourceAudioEnabled,

        /**
         * @var string Layout: TILED or SCREENSHARE
         */
        public string $groupLayout,

        /**
         * @var string|null Browser source token for OBS (null unless the caller is the broadcaster)
         */
        public ?string $browserSourceToken = null,

        /**
         * @var string|null Broadcaster ID (not sent by Twitch: filled in by getChannelGuestStarSettings())
         */
        public ?string $broadcasterId = null,
    ) {}
}
