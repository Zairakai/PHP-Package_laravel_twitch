<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `channel.poll.progress` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelpollprogress
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelPollProgressEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $id,
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public string $title,

        /**
         * @var array<int, mixed>
         */
        public array $choices,

        /**
         * @var array<string, mixed>
         */
        public array $bitsVoting,

        /**
         * @var array<string, mixed>
         */
        public array $channelPointsVoting,
        public string $startedAt,
        public string $endsAt,
    ) {}
}
