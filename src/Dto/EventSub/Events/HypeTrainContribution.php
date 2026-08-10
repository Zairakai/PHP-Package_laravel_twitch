<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * A single contributor entry inside `top_contributions` (always present) or
 * `shared_train_participants` (only on multi-channel shared hype trains) -
 * same shape.
 */
#[MapInputName(SnakeCaseMapper::class)]
class HypeTrainContribution extends Data
{
    public function __construct(
        public string $userId,
        public string $userLogin,
        public string $userName,

        /**
         * @var string bits or subscription
         */
        public string $type,
        public int $total,
    ) {}
}
