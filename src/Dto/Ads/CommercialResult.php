<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Ads;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents the result of starting a commercial.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#start-commercial
 */
#[MapInputName(SnakeCaseMapper::class)]
class CommercialResult extends TwitchData
{
    public function __construct(
        /**
         * @var int Duration of the commercial in seconds
         */
        public int $length,

        /**
         * @var string Empty string on success; error message on failure
         */
        public string $message,

        /**
         * @var int Seconds to wait before requesting another commercial
         */
        public int $retryAfter,
    ) {}
}
