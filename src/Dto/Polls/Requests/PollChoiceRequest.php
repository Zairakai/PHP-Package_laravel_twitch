<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Polls\Requests;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a poll choice for CreatePollRequest.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#create-poll
 */
#[MapOutputName(SnakeCaseMapper::class)]
class PollChoiceRequest extends Data
{
    public function __construct(
        /**
         * @var string Choice title (max 25 characters)
         */
        public readonly string $title,
    ) {}
}
