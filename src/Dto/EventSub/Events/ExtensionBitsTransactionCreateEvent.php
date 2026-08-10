<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub\Events;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Payload of a `extension.bits_transaction.create` EventSub notification.
 *
 * Fields generated from the official example payload on 2026-08-09.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types/#extensionbits_transactioncreate
 */
#[MapInputName(SnakeCaseMapper::class)]
class ExtensionBitsTransactionCreateEvent extends Data implements EventSubEvent
{
    public function __construct(
        public string $id,
        public string $extensionClientId,
        public string $broadcasterUserId,
        public string $broadcasterUserLogin,
        public string $broadcasterUserName,
        public string $userName,
        public string $userLogin,
        public string $userId,

        /**
         * @var array<string, mixed>
         */
        public array $product,
    ) {}
}
