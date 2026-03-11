<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\ChannelPoints;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a custom channel point reward.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-custom-reward
 */
#[MapInputName(SnakeCaseMapper::class)]
class CustomReward extends Data
{
    public function __construct(
        /**
         * @var string Broadcaster ID
         */
        public string $broadcasterId,

        /**
         * @var string Broadcaster login (lowercase)
         */
        public string $broadcasterLogin,

        /**
         * @var string Broadcaster display name
         */
        public string $broadcasterName,

        /**
         * @var string Reward ID
         */
        public string $id,

        /**
         * @var string Reward title
         */
        public string $title,

        /**
         * @var string Reward prompt shown at redemption
         */
        public string $prompt,

        /**
         * @var int Cost in Channel Points
         */
        public int $cost,

        /**
         * @var string Background color (hex #RRGGBB)
         */
        public string $backgroundColor,

        /**
         * @var bool Whether the reward is enabled
         */
        public bool $isEnabled,

        /**
         * @var bool Whether user input is required
         */
        public bool $isUserInputRequired,

        /**
         * @var bool Whether the reward is paused
         */
        public bool $isPaused,

        /**
         * @var bool Whether the reward is in stock
         */
        public bool $isInStock,

        /**
         * @var bool Whether redemptions skip the queue
         */
        public bool $shouldRedemptionsSkipRequestQueue,

        /**
         * @var int|null Max redemptions per stream (null = unlimited)
         */
        public ?int $maxPerStreamSetting = null,

        /**
         * @var int|null Max redemptions per user per stream (null = unlimited)
         */
        public ?int $maxPerUserPerStreamSetting = null,

        /**
         * @var int|null Global cooldown in seconds (null = no cooldown)
         */
        public ?int $globalCooldownSetting = null,

        /**
         * @var int|null Number of redemptions during current stream
         */
        public ?int $redemptionsRedeemedCurrentStream = null,

        /**
         * @var string|null When the cooldown expires (RFC3339)
         */
        public ?string $cooldownExpiresAt = null,

        /**
         * @var array{url: string|null, animated: array{url_1x: string, url_2x: string, url_4x: string}|null, static: array{url_1x: string, url_2x: string, url_4x: string}|null}|null Custom image
         */
        public ?array $image = null,

        /**
         * @var array{url_1x: string, url_2x: string, url_4x: string}|null Default image
         */
        public ?array $defaultImage = null,
    ) {}
}
