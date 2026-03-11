<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Bits;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a Bits transaction made through an extension.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-extension-transactions
 */
#[MapInputName(SnakeCaseMapper::class)]
class ExtensionTransaction extends Data
{
    public function __construct(
        /**
         * @var string Transaction ID
         */
        public string $id,

        /**
         * @var string ISO 8601 datetime of the transaction
         */
        public string $timestamp,

        /**
         * @var string Broadcaster's user ID
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
         * @var string User ID of the buyer
         */
        public string $userId,

        /**
         * @var string Buyer login (lowercase)
         */
        public string $userLogin,

        /**
         * @var string Buyer display name
         */
        public string $userName,

        /**
         * @var string Product type (e.g. "BITS_IN_EXTENSION")
         */
        public string $productType,

        /**
         * @var array<string, mixed> Product data (sku, cost, display_name, etc.)
         */
        public array $productData,
    ) {}
}
