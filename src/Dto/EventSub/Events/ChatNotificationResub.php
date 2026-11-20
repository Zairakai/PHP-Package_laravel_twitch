<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * `channel.chat.notification` payload when `notice_type` is `resub` (or
 * `shared_chat_resub`) - verified against the official example payload.
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChatNotificationResub extends TwitchData
{
    public function __construct(
        public int $cumulativeMonths,
        public int $durationMonths,
        public bool $isGift,

        /**
         * @var int|null Current streak in months - null if not shared
         */
        public ?int $streakMonths = null,
        public ?bool $gifterIsAnonymous = null,
        public ?string $gifterUserId = null,
        public ?string $gifterUserName = null,
        public ?string $gifterUserLogin = null,

        /**
         * @var string|null Subscription tier (1000, 2000 or 3000): `sub_tier` in the reference
         */
        public ?string $subTier = null,

        /**
         * @var string|null Same value, as `sub_plan` (the name in the example of the reference)
         */
        public ?string $subPlan = null,
        public ?bool $isPrime = null,
    ) {}

    /**
     * The reference names the tier `sub_tier` and its example `sub_plan`: both are read, whichever Twitch sends.
     *
     * @param array<mixed> $properties
     *
     * @return array<mixed>
     */
    public static function prepareForPipeline(array $properties): array
    {
        $properties = parent::prepareForPipeline($properties);

        $properties['sub_tier'] ??= $properties['sub_plan'] ?? null;
        $properties['sub_plan'] ??= $properties['sub_tier'] ?? null;

        return $properties;
    }
}
