<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `channel.unban_request.resolve` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelunban_requestresolve
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelUnbanRequestResolveEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $id,
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public string $moderatorUserId,
        public string $moderatorUserLogin,
        public string $moderatorUserName,
        public string $userId,
        public string $userLogin,
        public string $userName,

        /**
         * @var string|null Message from the resolver - genuinely optional,
         *                  not just unverified: the Helix "Resolve Unban
         *                  Requests" endpoint marks its equivalent
         *                  `resolution_text` request param "Required? No",
         *                  and the "Get Unban Requests" example response
         *                  shows a real `"resolution_text": null` for an
         *                  unresolved request - confirmed nullable by
         *                  Twitch's own docs, not inferred from a crash.
         */
        public ?string $resolutionText,
        public string $status,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->broadcasterUserId;
    }
}
