<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * `channel.chat.notification` payload when `notice_type` is
 * `gift_paid_upgrade` (a gifted sub converted to a paid one).
 *
 * Shape inferred from Twitch's documented EventSub schema, not
 * independently re-verified against a fetched example - double check
 * before relying on it in production.
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChatNotificationGiftPaidUpgrade extends TwitchData
{
    public function __construct(
        public bool $gifterIsAnonymous,
        public ?string $gifterUserId = null,
        public ?string $gifterUserName = null,
        public ?string $gifterUserLogin = null,
    ) {}
}
