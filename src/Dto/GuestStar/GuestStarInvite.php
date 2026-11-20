<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\GuestStar;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents a pending Guest Star session invitation.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-guest-star-invites
 */
#[MapInputName(SnakeCaseMapper::class)]
class GuestStarInvite extends TwitchData
{
    public function __construct(
        /**
         * @var string Invited user ID
         */
        public string $userId,

        /**
         * @var bool Whether the guest's video is enabled
         */
        public bool $isVideoEnabled,

        /**
         * @var bool Whether the guest's audio is enabled
         */
        public bool $isAudioEnabled,

        /**
         * @var Carbon|null When the invite was sent
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $invitedAt = null,

        /**
         * @var string|null Invite status (always INVITED: only pending invites are listed)
         */
        public ?string $status = null,

        /**
         * @var bool|null Whether the guest's video is available
         */
        public ?bool $isVideoAvailable = null,

        /**
         * @var bool|null Whether the guest's audio is available
         */
        public ?bool $isAudioAvailable = null,

        /**
         * @var string|null Not sent by Twitch
         */
        public ?string $userLogin = null,

        /**
         * @var string|null Not sent by Twitch
         */
        public ?string $userDisplayName = null,

        /**
         * @var bool|null Not sent by Twitch
         */
        public ?bool $isModerator = null,

        /**
         * @var bool|null Not sent by Twitch
         */
        public ?bool $isGuestStarParticipant = null,
    ) {}
}
