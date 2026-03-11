<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Chat\Structures;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents the body of a Twitch chat message.
 *
 * Contains the full plain-text message and a typed collection of fragments
 * that preserve the structure of the message (text, emotes, cheermotes, mentions).
 *
 * Usage:
 * ```php
 * $msg = Message::from($raw['event']['message']);
 * echo $msg->text; // "Cheer100 Hello @zairakai PogChamp"
 *
 * foreach ($msg->fragments as $fragment) {
 *     match ($fragment->type) {
 *         'cheermote' => doSomethingWithBits($fragment->cheermote),
 *         'emote'     => renderEmote($fragment->emote),
 *         'mention'   => pingUser($fragment->mention),
 *         default     => appendText($fragment->text),
 *     };
 * }
 * ```
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelchatmessage
 */
#[MapInputName(SnakeCaseMapper::class)]
class Message extends Data
{
    public function __construct(
        /**
         * @var string Full plain-text content of the message
         */
        public string $text,

        /**
         * @var DataCollection<int, MessageFragment> Typed fragments composing the message
         */
        #[DataCollectionOf(MessageFragment::class)]
        public DataCollection $fragments,
    ) {}
}
