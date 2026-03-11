<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Moderation;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents the Shield Mode status for a broadcaster's channel.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-shield-mode-status
 */
#[MapInputName(SnakeCaseMapper::class)]
class ShieldMode extends Data
{
    public function __construct(
        /**
         * @var bool Whether Shield Mode is currently active
         */
        public bool $isActive,

        /**
         * @var string ID of the moderator who last activated Shield Mode
         */
        public string $moderatorId,

        /**
         * @var string Login of the moderator who last activated Shield Mode
         */
        public string $moderatorLogin,

        /**
         * @var string Display name of the moderator who last activated Shield Mode
         */
        public string $moderatorName,

        /**
         * @var string|null When Shield Mode was last activated (RFC3339); empty string if never
         */
        public ?string $lastActivatedAt = null,
    ) {}
}
