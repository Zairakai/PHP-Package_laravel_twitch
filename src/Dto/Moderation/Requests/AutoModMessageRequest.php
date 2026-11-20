<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Moderation\Requests;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * A single message to check against AutoMod.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#check-automod-status
 */
#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class AutoModMessageRequest extends TwitchData
{
    public function __construct(
        /**
         * @var string Caller-defined ID for this message (used to match results)
         */
        public readonly string $msgId,

        /**
         * @var string Text of the message to evaluate
         */
        public readonly string $msgText,
    ) {}
}
