<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\ChannelPoints\Requests;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Request DTO for creating a custom channel point reward.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#create-custom-rewards
 */
#[MapOutputName(SnakeCaseMapper::class)]
class CreateCustomRewardRequest extends Data
{
    public function __construct(
        /**
         * @var string Reward title (max 45 characters)
         */
        public readonly string $title,

        /**
         * @var int Channel Points cost (1-1,000,000)
         */
        public readonly int $cost,

        /**
         * @var string|null Reward prompt shown at redemption (max 200 characters)
         */
        public readonly ?string $prompt = null,

        /**
         * @var bool|null Whether the reward is enabled (default true)
         */
        public readonly ?bool $isEnabled = null,

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
         * @var int|null Max redemptions per stream (required when isMaxPerStreamEnabled is true)
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
