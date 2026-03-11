<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Charity;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents an active charity campaign for a broadcaster.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-charity-campaign
 */
#[MapInputName(SnakeCaseMapper::class)]
class CharityCampaign extends Data
{
    public function __construct(
        /**
         * @var string Campaign ID
         */
        public string $id,

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
         * @var string Charity name
         */
        public string $charityName,

        /**
         * @var string Charity description
         */
        public string $charityDescription,

        /**
         * @var string URL of charity logo
         */
        public string $charityLogo,

        /**
         * @var string Charity website URL
         */
        public string $charityWebsite,

        /**
         * @var array{value: int, decimal_places: int, currency: string} Current amount raised
         */
        public array $currentAmount,

        /**
         * @var array{value: int, decimal_places: int, currency: string}|null Target donation amount
         */
        public ?array $targetAmount = null,
    ) {}
}
