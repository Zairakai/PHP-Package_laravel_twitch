<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Payload of a `channel.moderate` EventSub notification.
 *
 * This is a discriminated-union event: exactly one of the optional fields
 * below is populated depending on the value of `action` - all others are
 * null, regardless of which one the single reference example happened to
 * show (only `mod` was populated there).
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelmoderate
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelModerateEvent extends TwitchData implements EventSubEvent
{
    public function __construct(
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public string $moderatorUserId,
        public string $moderatorUserLogin,
        public string $moderatorUserName,
        public string $action,

        /**
         * @var array{follow_duration_minutes: int}|null Present when action is 'followers'
         */
        public ?array $followers = null,

        /**
         * @var array{wait_time_seconds: int}|null Present when action is 'slow'
         */
        public ?array $slow = null,
        public ?EventSubUserReference $vip = null,
        public ?EventSubUserReference $unvip = null,
        public ?EventSubUserReference $mod = null,
        public ?EventSubUserReference $unmod = null,
        public ?ModerateBanAction $ban = null,
        public ?EventSubUserReference $unban = null,
        public ?ModerateTimeoutAction $timeout = null,
        public ?EventSubUserReference $untimeout = null,
        public ?ModerateRaidAction $raid = null,

        /**
         * @var EventSubUserReference|null Present when action is 'unraid'
         */
        public ?EventSubUserReference $unraid = null,
        public ?ModerateDeleteAction $delete = null,
        public ?ModerateAutomodTermsAction $automodTerms = null,
        public ?ModerateUnbanRequestAction $unbanRequest = null,

        /**
         * Shared-chat mirror of ban.
         */
        public ?ModerateBanAction $sharedChatBan = null,

        /**
         * Shared-chat mirror of unban.
         */
        public ?EventSubUserReference $sharedChatUnban = null,

        /**
         * Shared-chat mirror of timeout.
         */
        public ?ModerateTimeoutAction $sharedChatTimeout = null,

        /**
         * Shared-chat mirror of untimeout.
         */
        public ?EventSubUserReference $sharedChatUntimeout = null,

        /**
         * Shared-chat mirror of delete.
         */
        public ?ModerateDeleteAction $sharedChatDelete = null,

        /**
         * Present when action is `warn` (version 2 only).
         */
        public ?ModerateWarnAction $warn = null,

        /**
         * @var string|null Channel where the action was taken (shared chat); the broadcaster when it is the same channel
         */
        public ?string $sourceBroadcasterUserId = null,
        public ?string $sourceBroadcasterUserLogin = null,
        public ?string $sourceBroadcasterUserName = null,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->broadcasterUserId;
    }
}
