<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Chat\Structures;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents an emote fragment within a chat message.
 *
 * Note: distinct from Emote (the API resource).
 * This is the lightweight fragment embedded in a message.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelchatmessage
 */
#[MapInputName(SnakeCaseMapper::class)]
class EmoteFragment extends TwitchData
{
    public function __construct(
        /**
         * @var string Emote ID
         */
        public string $id,

        /**
         * @var string Emote set ID the emote belongs to
         */
        public string $emoteSetId,

        /**
         * @var string|null Owner channel ID (broadcaster who owns the emote). Absent from the automod payloads.
         */
        public ?string $ownerId = null,

        /**
         * @var array<string> Available formats: animated, static. Absent from the automod payloads.
         */
        public array $format = [],
    ) {}
}
