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
 * Payload of a `channel.shoutout.receive` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelshoutoutreceive
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelShoutoutReceiveEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $broadcasterUserId,
        public string $broadcasterUserName,
        public string $broadcasterUserLogin,
        public string $fromBroadcasterUserId,
        public string $fromBroadcasterUserName,
        public string $fromBroadcasterUserLogin,
        public int $viewerCount,
        #[WithCast(FlexibleDateTimeCast::class)]
        public Carbon $startedAt,
    ) {}
}
