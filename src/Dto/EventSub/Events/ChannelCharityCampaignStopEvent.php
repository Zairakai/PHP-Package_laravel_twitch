<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;

/**
 * Payload of a `channel.charity_campaign.stop` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelcharity_campaignstop
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelCharityCampaignStopEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $id,
        public string $broadcasterId,
        public string $broadcasterName,
        public string $broadcasterLogin,
        public string $charityName,
        public string $charityDescription,
        public string $charityLogo,
        public string $charityWebsite,

        /**
         * @var array<string, mixed>
         */
        public array $currentAmount,

        /**
         * @var array<string, mixed>
         */
        public array $targetAmount,
        #[WithCast(FlexibleDateTimeCast::class)]
        public Carbon $stoppedAt,
    ) {}
}
