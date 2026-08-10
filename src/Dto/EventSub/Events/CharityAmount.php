<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * A monetary amount as Twitch represents it on charity campaign events
 * (`{value, decimal_places, currency}`) - `value` is the smallest currency
 * unit (e.g. cents), divide by `10 ** decimal_places` for the display amount.
 */
#[MapInputName(SnakeCaseMapper::class)]
class CharityAmount extends Data
{
    public function __construct(
        public int $value,
        public int $decimalPlaces,

        /**
         * @var string ISO 4217 currency code (e.g. USD)
         */
        public string $currency,
    ) {}
}
