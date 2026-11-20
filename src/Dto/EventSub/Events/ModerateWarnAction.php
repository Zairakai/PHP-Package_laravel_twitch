<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * `channel.moderate` v2 payload when `action` is `warn`.
 *
 * @see https://dev.twitch.tv/docs/eventsub/reference/channel-moderation
 */
#[MapInputName(SnakeCaseMapper::class)]
class ModerateWarnAction extends TwitchData
{
    public function __construct(
        public string $userId,
        public string $userLogin,
        public string $userName,
        public ?string $reason = null,

        /**
         * @var list<string>|null Chat rules cited by the moderator
         */
        public ?array $chatRulesCited = null,
    ) {}
}
