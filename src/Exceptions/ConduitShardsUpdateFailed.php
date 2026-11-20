<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Exceptions;

use RuntimeException;
use Spatie\LaravelData\DataCollection;
use Zairakai\LaravelTwitch\Dto\Conduits\ConduitShard;

/**
 * Twitch answered 202 to Update Conduit Shards but refused some of the shards.
 *
 * The request is not atomic: the shards that were accepted are in {@see $shards}, the refused ones in
 * {@see $errors} (one entry per shard, with its `id`, a `message` and a `code`).
 */
final class ConduitShardsUpdateFailed extends RuntimeException
{
    /**
     * @param list<array<string, mixed>>        $errors
     * @param DataCollection<int, ConduitShard> $shards
     */
    public function __construct(
        public readonly array $errors,
        public readonly DataCollection $shards,
    ) {
        $details = array_map(
            static fn (array $error): string => sprintf(
                'shard %s: %s',
                is_scalar($error['id'] ?? null) ? (string) $error['id'] : '?',
                is_scalar($error['message'] ?? null) ? (string) $error['message'] : 'refused',
            ),
            $errors,
        );

        parent::__construct(sprintf(
            'Twitch refused %d conduit shard update(s): %s',
            count($errors),
            implode('; ', $details),
        ));
    }
}
