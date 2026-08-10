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
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $followers = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $slow = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $vip = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $unvip = null,

        /**
         * @var array<string, mixed>|null
         */
        public ?array $mod = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $unmod = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $ban = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $unban = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $timeout = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $untimeout = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $raid = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $unraid = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $delete = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $automodTerms = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $unbanRequest = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sharedChatBan = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sharedChatUnban = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sharedChatTimeout = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sharedChatUntimeout = null,

        /**
         * @var mixed Not present in the reference example payload (always null there) - real type unconfirmed
         */
        public mixed $sharedChatDelete = null,
    ) {}
}
