<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\TwitchData;

/**
 * Payload of a `channel.charity_campaign.progress` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelcharity_campaignprogress
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelCharityCampaignProgressEvent extends TwitchData implements EventSubEvent
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
        public CharityAmount $currentAmount,
        public CharityAmount $targetAmount,
    ) {}

    public function getBroadcasterUserId(): string
    {
        return $this->broadcasterId;
    }
}
