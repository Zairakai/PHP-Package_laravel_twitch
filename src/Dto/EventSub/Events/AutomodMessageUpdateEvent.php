<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\Chat\Structures\Message;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Payload of a `automod.message.update` EventSub notification (v1 and v2) - a
 * previously held message being approved/denied/expired by a moderator.
 *
 * Corrected against a real notification captured during Monsieur's
 * 2026-08-27 stream - the original flat fields (`message` as a plain
 * string, top-level `level`/`category`/`fragments`) were generated from
 * documentation on 2026-08-09 and never independently verified; the real
 * wire payload nests message text/fragments under `message` and the
 * AutoMod verdict under `automod`, same discriminated-union shape as the
 * sibling `automod.message.hold` (`AutomodMessageHoldEvent`).
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#automodmessageupdate
 */
#[MapInputName(SnakeCaseMapper::class)]
class AutomodMessageUpdateEvent extends TwitchData implements EventSubEvent
{
    public function __construct(
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public string $userId,
        public string $userLogin,
        public string $userName,
        public string $moderatorUserId,
        public string $moderatorUserLogin,
        public string $moderatorUserName,
        public string $messageId,
        public Message $message,

        /**
         * @var string 'approved', 'denied' or 'expired'
         */
        public string $status,
        #[WithCast(FlexibleDateTimeCast::class)]
        public Carbon $heldAt,

        /**
         * @var string|null v2 only: 'automod', 'blocked_term' or 'blocked_link'
         */
        public ?string $reason = null,

        /**
         * @var string|null v1 only: category of the AutoMod detection (v2: see `automod`)
         */
        public ?string $category = null,

        /**
         * @var int|null v1 only: level of the AutoMod detection, 1 to 4 (v2: see `automod`)
         */
        public ?int $level = null,

        /**
         * @var array{category: string, level: int, boundaries: list<array{start_pos: int, end_pos: int}>}|null
         *                                                                                                      v2 only: present when reason is 'automod'
         */
        public ?array $automod = null,

        /**
         * @var array{terms_found: list<array{term_id: string, owner_broadcaster_user_id: string, owner_broadcaster_user_login: string, owner_broadcaster_user_name: string, boundary: array{start_pos: int, end_pos: int}}>}|null
         *                                                                                                                                                                                                                         v2 only: present when reason is 'blocked_term'
         */
        public ?array $blockedTerm = null,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->broadcasterUserId;
    }
}
