<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Chat\Structures;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a single fragment in a Twitch chat message.
 *
 * A message is composed of multiple fragments. Each fragment has a type
 * (text, cheermote, emote, or mention) and only the corresponding
 * sub-DTO is populated; the others are null.
 *
 * Example message "Cheer100 Hello @zairakai PogChamp":
 *   - Fragment 1: type=cheermote, cheermote={prefix:"Cheer", bits:100, tier:1}
 *   - Fragment 2: type=text, text=" Hello "
 *   - Fragment 3: type=mention, mention={userId:"...", userLogin:"zairakai", userName:"Zairakai"}
 *   - Fragment 4: type=emote, emote={id:"...", emoteSetId:"...", ownerId:"...", format:["static"]}
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelchatmessage
 */
#[MapInputName(SnakeCaseMapper::class)]
class MessageFragment extends Data
{
    public function __construct(
        /**
         * @var string Fragment type: text, cheermote, emote, or mention
         */
        public string $type,

        /**
         * @var string|null Raw text content (populated when type=text, also present for cheermote/emote as display text)
         */
        public ?string $text,

        /**
         * @var CheermoteFragment|null Cheermote data (populated when type=cheermote)
         */
        public ?CheermoteFragment $cheermote,

        /**
         * @var EmoteFragment|null Emote data (populated when type=emote)
         */
        public ?EmoteFragment $emote,

        /**
         * @var MentionFragment|null Mention data (populated when type=mention)
         */
        public ?MentionFragment $mention,
    ) {}
}
