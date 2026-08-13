<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub;

use Carbon\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;
use Zairakai\LaravelTwitch\Dto\EventSub\Casts\FlexibleDateTimeCast;

/**
 * Represents an EventSub subscription.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-eventsub-subscriptions
 */
#[MapInputName(SnakeCaseMapper::class)]
class Subscription extends Data
{
    public function __construct(
        /**
         * @var string Subscription ID
         */
        public string $id,

        /**
         * @var string Subscription type (e.g. channel.follow)
         */
        public string $type,

        /**
         * @var string Type version
         */
        public string $version,

        /**
         * @var string Status: enabled, webhook_callback_verification_pending, etc.
         */
        public string $status,

        /**
         * @var int Cost of this subscription (affects subscription limit)
         */
        public int $cost,

        /**
         * @var array<string, string> Subscription condition parameters
         */
        public array $condition,

        /**
         * @var array<string, string> Transport info (method, callback/session_id)
         */
        public array $transport,

        /**
         * @var Carbon|null When the subscription was created
         */
        #[WithCast(FlexibleDateTimeCast::class)]
        public ?Carbon $createdAt = null,
    ) {}
}
