<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `user.authorization.revoke` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#userauthorizationrevoke
 */
#[MapInputName(SnakeCaseMapper::class)]
class UserAuthorizationRevokeEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $clientId,
        public string $userId,
        public string $userLogin,
        public string $userName,
    ) {}
}
