<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\ChannelPoints;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Represents a channel point reward redemption.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-custom-reward-redemption
 */
#[MapInputName(SnakeCaseMapper::class)]
class Redemption extends TwitchData
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
         * @var string Redemption ID
         */
        public string $id,

        /**
         * @var string Redeemer user ID
         */
        public string $userId,

        /**
         * @var string Redeemer login (lowercase)
         */
        public string $userLogin,

        /**
         * @var string Redeemer display name
         */
        public string $userName,

        /**
         * @var string Status: CANCELED, FULFILLED, UNFULFILLED
         */
        public string $status,

        /**
         * @var string Reward ID
         */
        public ?string $rewardId = null,

        /**
         * @var string Reward title
         */
        public ?string $rewardTitle = null,

        /**
         * @var int Reward cost
         */
        public ?int $rewardCost = null,

        /**
         * @var string Reward prompt
         */
        public ?string $rewardPrompt = null,

        /**
         * @var string|null User input (if required)
         */
        public ?string $userInput = null,

        /**
         * @var Carbon|null When the redemption occurred
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $redeemedAt = null,

        /**
         * @var array{id: string, title: string, prompt: string, cost: int}|null The reward, as Twitch sends it
         */
        public ?array $reward = null,
    ) {}

    /**
     * Twitch sends the reward as an object: its fields are also available flat (rewardId, rewardTitle...).
     *
     * @param array<mixed> $properties
     *
     * @return array<mixed>
     */
    public static function prepareForPipeline(array $properties): array
    {
        $properties = parent::prepareForPipeline($properties);

        $reward = $properties['reward'] ?? null;

        if (is_array($reward)) {
            $properties['reward_id']     ??= $reward['id']     ?? null;
            $properties['reward_title']  ??= $reward['title']  ?? null;
            $properties['reward_prompt'] ??= $reward['prompt'] ?? null;
            $properties['reward_cost']   ??= $reward['cost']   ?? null;
        }

        return $properties;
    }
}
