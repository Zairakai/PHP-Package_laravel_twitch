<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Charity;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a donation to a charity campaign.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-charity-campaign-donations
 */
#[MapInputName(SnakeCaseMapper::class)]
class CharityDonation extends Data
{
    public function __construct(
        /**
         * @var string Donation ID
         */
        public string $id,

        /**
         * @var string ID of the charity campaign
         */
        public string $campaignId,

        /**
         * @var string User ID of the donor
         */
        public string $userId,

        /**
         * @var string User login of the donor
         */
        public string $userLogin,

        /**
         * @var string Display name of the donor
         */
        public string $userName,

        /**
         * @var array{value: int, decimal_places: int, currency: string} Donation amount
         */
        public array $amount,
    ) {}
}
