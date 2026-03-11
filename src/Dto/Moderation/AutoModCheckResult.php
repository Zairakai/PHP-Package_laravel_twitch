<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Moderation;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents the result of an AutoMod status check for a single message.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#check-automod-status
 */
#[MapInputName(SnakeCaseMapper::class)]
class AutoModCheckResult extends Data
{
    public function __construct(
        /**
         * @var string The caller-provided message ID
         */
        public string $msgId,

        /**
         * @var bool Whether the message would be permitted by AutoMod
         */
        public bool $isPermitted,
    ) {}
}
