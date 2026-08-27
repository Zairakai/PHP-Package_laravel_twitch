<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Bits;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a broadcaster's custom Bits Power-up (distinct from
 * ChannelCustomPowerUpRedemptionAddEvent, which is a redemption of one of
 * these, not the catalog entry itself).
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-custom-power-up
 */
#[MapInputName(SnakeCaseMapper::class)]
class CustomPowerUp extends Data
{
    public function __construct(
        public string $broadcasterId,
        public string $broadcasterLogin,
        public string $broadcasterName,
        public string $id,
        public string $title,
        public string $prompt,
        public int $bits,
        public string $backgroundColor,
        public bool $isEnabled,
        public bool $isUserInputRequired,
        public bool $isPaused,
        public bool $isInStock,

        /**
         * @var array{url_1x: string, url_2x: string, url_4x: string}|null
         */
        public ?array $image = null,

        /**
         * @var array{url_1x: string, url_2x: string, url_4x: string}|null
         */
        public ?array $defaultImage = null,

        /**
         * @var array{is_enabled: bool, max_per_stream: int}|null
         */
        public ?array $maxPerStreamSetting = null,

        /**
         * @var array{is_enabled: bool, max_per_user_per_stream: int}|null
         */
        public ?array $maxPerUserPerStreamSetting = null,

        /**
         * @var array{is_enabled: bool, global_cooldown_seconds: int}|null
         */
        public ?array $globalCooldownSetting = null,
        public ?int $redemptionsRedeemedCurrentStream = null,
        public ?string $cooldownExpiresAt = null,
    ) {}
}
