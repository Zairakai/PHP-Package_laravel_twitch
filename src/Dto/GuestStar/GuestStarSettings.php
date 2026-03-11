<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\GuestStar;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents the Guest Star settings for a broadcaster's channel.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-channel-guest-star-settings
 */
#[MapInputName(SnakeCaseMapper::class)]
class GuestStarSettings extends Data
{
    public function __construct(
        /**
         * @var string Broadcaster ID
         */
        public string $broadcasterId,

        /**
         * @var bool Whether moderators can send guests live
         */
        public bool $isModeratorSendLiveEnabled,

        /**
         * @var int Number of available guest slots (1-8)
         */
        public int $slotCount,

        /**
         * @var bool Whether browser source audio is enabled
         */
        public bool $isBrowserSourceAudioEnabled,

        /**
         * @var string Layout: TILED_LAYOUT, SCREENSHARE_LAYOUT, HORIZONTAL_LAYOUT, VERTICAL_LAYOUT
         */
        public string $groupLayout,

        /**
         * @var string Browser source token for OBS
         */
        public string $browserSourceToken = '',
    ) {}
}
