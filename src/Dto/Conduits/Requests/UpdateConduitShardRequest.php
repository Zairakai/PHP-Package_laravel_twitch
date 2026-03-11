<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\Conduits\Requests;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

/**
 * Request DTO for a single shard update within a conduit.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#update-conduit-shards
 */
#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class UpdateConduitShardRequest extends Data
{
    public function __construct(
        /**
         * @var string Shard ID to update
         */
        public readonly string $id,

        /**
         * @var array<string, mixed> Transport configuration (method, callback/session_id, secret, etc.)
         */
        public readonly array $transport,
    ) {}
}
