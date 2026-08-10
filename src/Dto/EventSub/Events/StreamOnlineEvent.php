<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `stream.online` EventSub notification.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#streamonline
 */
#[MapInputName(SnakeCaseMapper::class)]
class StreamOnlineEvent extends Data implements EventSubEvent
{
    public function __construct(
        /**
         * @var string Stream ID
         */
        public string $id,
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,

        /**
         * @var string Stream type: live, playlist, watch_party, premiere or rerun
         */
        public string $type,
        public Carbon $startedAt,
    ) {}
}
