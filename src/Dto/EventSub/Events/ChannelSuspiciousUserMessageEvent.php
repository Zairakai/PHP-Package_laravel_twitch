<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `channel.suspicious_user.message` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelsuspicious_usermessage
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelSuspiciousUserMessageEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $broadcasterUserId,
        public string $broadcasterUserName,
        public string $broadcasterUserLogin,
        public string $userId,
        public string $userName,
        public string $userLogin,
        public string $lowTrustStatus,

        /**
         * @var array<int, mixed>
         */
        public array $sharedBanChannelIds,

        /**
         * @var array<int, mixed>
         */
        public array $types,
        public string $banEvasionEvaluation,

        /**
         * @var array<string, mixed>
         */
        public array $message,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->broadcasterUserId;
    }
}
