<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Conduits;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Represents a single shard within an EventSub conduit.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-conduit-shards
 */
#[MapInputName(SnakeCaseMapper::class)]
class ConduitShard extends Data
{
    public function __construct(
        /**
         * @var string Shard ID
         */
        public string $id,

        /**
         * @var string Shard status (enabled, webhook_callback_verification_pending, etc.)
         */
        public string $status,

        /**
         * @var array<string, mixed> Transport details (method, callback or session_id)
         */
        public array $transport = [],
    ) {}
}
