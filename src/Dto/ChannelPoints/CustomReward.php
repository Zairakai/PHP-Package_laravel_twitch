<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\ChannelPoints;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents a custom channel point reward.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-custom-reward
 */
#[MapInputName(SnakeCaseMapper::class)]
class CustomReward extends TwitchData
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
         * @var array{is_enabled: bool, max_per_stream: int}|null Max redemptions per stream
         */
        public ?array $maxPerStreamSetting = null,

        /**
         * @var array{is_enabled: bool, max_per_user_per_stream: int}|null Max redemptions per user per stream
         */
        public ?array $maxPerUserPerStreamSetting = null,

        /**
         * @var array{is_enabled: bool, global_cooldown_seconds: int}|null Global cooldown
         */
        public ?array $globalCooldownSetting = null,

        /**
         * @var int|null Number of redemptions during current stream
         */
        public ?int $redemptionsRedeemedCurrentStream = null,

        /**
         * @var string|null When the cooldown expires (RFC3339)
         */
        public ?string $cooldownExpiresAt = null,

        /**
         * @var array{url_1x: string, url_2x: string, url_4x: string}|null Custom image (null when the reward has none)
         */
        public ?array $image = null,

        /**
         * @var array{url_1x: string, url_2x: string, url_4x: string}|null Default image
         */
        public ?array $defaultImage = null,
    ) {}
}
