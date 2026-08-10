<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;

/**
 * `channel.moderate` payload when `action` is `timeout` (temporary - see
 * ModerateBanAction for the permanent variant). Reused for
 * `shared_chat_timeout`.
 *
 * Shape inferred from Twitch's documented EventSub schema, not
 * independently re-verified against a fetched example - double check
 * before relying on it in production.
 */
#[MapInputName(SnakeCaseMapper::class)]
class ModerateTimeoutAction extends Data
{
    public function __construct(
        public string $userId,
        public string $userLogin,
        public string $userName,
        public string $reason,
        #[WithCast(FlexibleDateTimeCast::class)]
        public Carbon $expiresAt,
    ) {}
}
