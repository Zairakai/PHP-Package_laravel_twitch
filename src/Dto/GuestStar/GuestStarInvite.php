<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\GuestStar;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a pending Guest Star session invitation.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-guest-star-invites
 */
#[MapInputName(SnakeCaseMapper::class)]
class GuestStarInvite extends Data
{
    public function __construct(
        /**
         * @var string User ID of the invited guest
         */
        public string $userId,

        /**
         * @var string User login of the invited guest
         */
        public string $userLogin,

        /**
         * @var string Display name of the invited guest
         */
        public string $userDisplayName,

        /**
         * @var bool Whether the guest's video is enabled
         */
        public bool $isVideoEnabled,

        /**
         * @var bool Whether the guest's audio is enabled
         */
        public bool $isAudioEnabled,

        /**
         * @var bool Whether the guest is a moderator
         */
        public bool $isModerator,

        /**
         * @var bool Whether the guest has Guest Star participant status
         */
        public bool $isGuestStarParticipant,
    ) {}
}
