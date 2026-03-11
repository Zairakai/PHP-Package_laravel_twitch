<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Channel;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a channel editor.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-channel-editors
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelEditor extends Data
{
    public function __construct(
        /**
         * @var string Editor user ID
         */
        public string $userId,

        /**
         * @var string Editor display name
         */
        public string $userName,

        /**
         * @var Carbon|null When the user was added as an editor
         */
        public ?Carbon $createdAt = null,
    ) {}
}
