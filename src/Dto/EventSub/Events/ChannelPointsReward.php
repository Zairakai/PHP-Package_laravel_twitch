<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Reward snapshot nested inside a channel points redemption EventSub event.
 *
 * Distinct from Dto\ChannelPoints\CustomReward (Helix API shape, more fields,
 * different property names) - this is the smaller shape Twitch embeds inline
 * in the EventSub redemption payload.
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelPointsReward extends TwitchData
{
    public function __construct(
        public string $id,
        public string $title,
        public int $cost,

        /**
         * @var string|null Reward description shown to viewers - null when the
         *                  reward has no prompt text configured
         */
        public ?string $prompt = null,
    ) {}
}
