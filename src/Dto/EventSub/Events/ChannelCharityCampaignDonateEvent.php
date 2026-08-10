<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `channel.charity_campaign.donate` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#channelcharity_campaigndonate
 */
#[MapInputName(SnakeCaseMapper::class)]
class ChannelCharityCampaignDonateEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $id,
        public string $campaignId,
        public string $broadcasterUserId,
        public string $broadcasterUserName,
        public string $broadcasterUserLogin,
        public string $userId,
        public string $userLogin,
        public string $userName,
        public string $charityName,
        public string $charityDescription,
        public string $charityLogo,
        public string $charityWebsite,

        /**
         * @var array<string, mixed>
         */
        public array $amount,
    ) {}
}
