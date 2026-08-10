<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `channel.moderate` EventSub notification.
 *
 * This is a discriminated-union event: exactly one of the optional fields
 * below is populated depending on the value of the discriminator field -
 * all others are null. Every optional field is nullable regardless of what
 * the single reference example happened to show.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelmoderate
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelModerateEvent extends Data implements EventSubEvent
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

        /**
         * @var array{user_id: string, user_login: string, user_name: string}|null Present when action is 'vip'
         */
        public ?array $vip = null,

        /**
         * @var array{user_id: string, user_login: string, user_name: string}|null Present when action is 'unvip'
         */
        public ?array $unvip = null,

        /**
         * @var array<string, mixed>|null
         */
        public ?array $mod = null,

        /**
         * @var array{user_id: string, user_login: string, user_name: string}|null Present when action is 'unmod'
         */
        public ?array $unmod = null,

        /**
         * @var array<string, mixed>|null Present when action is 'ban': {user_id, user_login, user_name, reason}
         */
        public ?array $ban = null,

        /**
         * @var array{user_id: string, user_login: string, user_name: string}|null Present when action is 'unban'
         */
        public ?array $unban = null,

        /**
         * @var array<string, mixed>|null Present when action is 'timeout': {user_id, user_login, user_name, reason, expires_at}
         */
        public ?array $timeout = null,

        /**
         * @var array{user_id: string, user_login: string, user_name: string}|null Present when action is 'untimeout'
         */
        public ?array $untimeout = null,

        /**
         * @var array<string, mixed>|null Present when notice_type is 'raid': {user_id, user_login, user_name, viewer_count, profile_image_url}
         */
        public ?array $raid = null,

        /**
         * @var array<string, mixed>|null Present when notice_type is 'unraid'
         */
        public ?array $unraid = null,

        /**
         * @var array<string, mixed>|null Present when action is 'delete': {user_id, user_login, user_name, message_id, message_body}
         */
        public ?array $delete = null,

        /**
         * @var array<string, mixed>|null Present when action is 'automod_terms': {action, list, terms, from_automod}
         */
        public ?array $automodTerms = null,

        /**
         * @var array<string, mixed>|null Present when action is 'unban_request': {is_approved, user_id, user_login, user_name, moderator_message}
         */
        public ?array $unbanRequest = null,

        /**
         * @var array<string, mixed>|null Shared-chat mirror of ban
         */
        public ?array $sharedChatBan = null,

        /**
         * @var array<string, mixed>|null Shared-chat mirror of unban
         */
        public ?array $sharedChatUnban = null,

        /**
         * @var array<string, mixed>|null Shared-chat mirror of timeout
         */
        public ?array $sharedChatTimeout = null,

        /**
         * @var array<string, mixed>|null Shared-chat mirror of untimeout
         */
        public ?array $sharedChatUntimeout = null,

        /**
         * @var array<string, mixed>|null Shared-chat mirror of delete
         */
        public ?array $sharedChatDelete = null,
    ) {}
}
