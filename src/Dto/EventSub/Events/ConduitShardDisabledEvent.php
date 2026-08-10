<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `conduit.shard.disabled` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#conduitsharddisabled
 */
#[MapInputName(SnakeCaseMapper::class)]
class ConduitShardDisabledEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $conduitId,
        public string $shardId,
        public string $status,

        /**
         * @var array<string, mixed>
         */
        public array $transport,
    ) {}
}
