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
 * Payload of a `automod.message.hold` EventSub notification (v1 and v2) - a message
 * pending moderator review, not yet visible in chat.
 *
 * A discriminated union on `reason`: exactly one of `automod`/`blockedTerm`
 * is populated depending on whether AutoMod's own detection or a
 * broadcaster-defined blocked term caused the hold - same pattern as
 * ChannelModerateEvent's action-specific fields. Left as typed array
 * shapes rather than dedicated Data classes, matching ChannelModerateEvent's
 * own `followers`/`slow` fields - neither shape is reused anywhere else in
 * the package.
 *
 * Previously unmapped in EventSubEventFactory::TYPE_MAP - fell through to
 * GenericEventSubEvent, which stores the raw, untransformed Twitch wire
 * payload (snake_case) instead of a typed DTO. Confirmed against a real
 * notification captured 2026-08-26.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#automodmessagehold
 */
#[MapInputName(SnakeCaseMapper::class)]
class AutomodMessageHoldEvent extends TwitchData implements EventSubEvent
{
    public function __construct(
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public string $userId,
        public string $userLogin,
        public string $userName,
        public string $messageId,
        public Message $message,
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
