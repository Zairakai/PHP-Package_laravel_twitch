<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Channel\Requests;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Request DTO for updating a channel's properties.
 *
 * All fields are optional — send only the ones you want to change.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#modify-channel-information
 */
#[MapOutputName(SnakeCaseMapper::class)]
class UpdateChannelRequest extends Data
{
    public function __construct(
        /**
         * @var string|null Game/category ID (use "0" to clear)
         */
        public readonly ?string $gameId = null,

        /**
         * @var string|null Stream language (ISO 639-1, or "other")
         */
        public readonly ?string $broadcasterLanguage = null,

        /**
         * @var string|null Stream title (max 140 chars)
         */
        public readonly ?string $title = null,

        /**
         * @var int|null Stream delay in seconds (0–900, partner only)
         */
        public readonly ?int $delay = null,

        /**
         * @var array<string>|null Tags applied to the channel (max 10, max 25 chars each)
         */
        public readonly ?array $tags = null,

        /**
         * @var array<int, array{id: string, is_enabled: bool}>|null Content classification labels
         */
        public readonly ?array $contentClassificationLabels = null,

        /**
         * @var bool|null Whether the channel is flagged as branded content
         */
        public readonly ?bool $isBrandedContent = null,
    ) {}
}
