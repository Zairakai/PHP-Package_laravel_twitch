<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Chat;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a Twitch chat badge set.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-channel-chat-badges
 */
#[MapInputName(SnakeCaseMapper::class)]
class Badge extends Data
{
    public function __construct(
        /**
         * @var string Badge set ID (e.g. subscriber, moderator)
         */
        public string $setId,

        /**
         * @var array<int, array{
         *     id: string,
         *     image_url_1x: string,
         *     image_url_2x: string,
         *     image_url_4x: string,
         *     title: string,
         *     description: string,
         *     click_action: string|null,
         *     click_url: string|null
         * }> Badge versions
         */
        public array $versions,
    ) {}
}
