<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\ChannelPoints\Requests;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Request DTO for updating a custom channel point reward.
 *
 * All fields are optional — only provided fields will be updated.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#update-custom-reward
 */
#[MapOutputName(SnakeCaseMapper::class)]
class UpdateCustomRewardRequest extends Data
{
    public function __construct(
        /**
         * @var string|null Reward title (max 45 characters)
         */
        public readonly ?string $title = null,

        /**
         * @var int|null Channel Points cost (1-1,000,000)
         */
        public readonly ?int $cost = null,

        /**
         * @var string|null Reward prompt (max 200 characters)
         */
        public readonly ?string $prompt = null,

        /**
         * @var bool|null Whether the reward is enabled
         */
        public readonly ?bool $isEnabled = null,

        /**
         * @var bool|null Whether the reward is paused
         */
        public readonly ?bool $isPaused = null,

        /**
         * @var string|null Background color (hex #RRGGBB)
         */
        public readonly ?string $backgroundColor = null,

        /**
         * @var bool|null Whether user input is required
         */
        public readonly ?bool $isUserInputRequired = null,

        /**
         * @var bool|null Whether max redemptions per stream is enabled
         */
        public readonly ?bool $isMaxPerStreamEnabled = null,

        /**
         * @var int|null Max redemptions per stream
         */
        public readonly ?int $maxPerStream = null,

        /**
         * @var bool|null Whether max redemptions per user per stream is enabled
         */
        public readonly ?bool $isMaxPerUserPerStreamEnabled = null,

        /**
         * @var int|null Max redemptions per user per stream
         */
        public readonly ?int $maxPerUserPerStream = null,

        /**
         * @var bool|null Whether global cooldown is enabled
         */
        public readonly ?bool $isGlobalCooldownEnabled = null,

        /**
         * @var int|null Global cooldown in seconds
         */
        public readonly ?int $globalCooldownSeconds = null,

        /**
         * @var bool|null Whether redemptions skip the request queue
         */
        public readonly ?bool $shouldRedemptionsSkipRequestQueue = null,
    ) {}
}
