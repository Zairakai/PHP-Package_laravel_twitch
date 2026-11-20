<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Payload of a `user.authorization.revoke` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#userauthorizationrevoke
 */
#[MapInputName(SnakeCaseMapper::class)]
class UserAuthorizationRevokeEvent extends TwitchData implements EventSubEvent
{
    public function __construct(
        public string $clientId,
        public string $userId,

        /**
         * @var string|null Null when the user no longer exists
         */
        public ?string $userLogin = null,

        /**
         * @var string|null Null when the user no longer exists
         */
        public ?string $userName = null,
    ) {}

    public function getBroadcasterUserId(): ?string
    {
        return null;
    }
}
