<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Moderation;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a blocked term in a broadcaster's channel.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-blocked-terms
 */
#[MapInputName(SnakeCaseMapper::class)]
class BlockedTerm extends Data
{
    public function __construct(
        /**
         * @var string Term ID
         */
        public string $id,

        /**
         * @var string Broadcaster ID
         */
        public string $broadcasterId,

        /**
         * @var string Moderator ID who added the term
         */
        public string $moderatorId,

        /**
         * @var string The blocked term text
         */
        public string $text,

        /**
         * @var Carbon|null When the term was added
         */
        public ?Carbon $createdAt = null,

        /**
         * @var Carbon|null When the term was last updated
         */
        public ?Carbon $updatedAt = null,

        /**
         * @var Carbon|null When the term expires (null = never)
         */
        public ?Carbon $expiresAt = null,
    ) {}
}
