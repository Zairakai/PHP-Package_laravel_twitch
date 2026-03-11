<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto;

use Spatie\LaravelData\Data;

/**
 * Generic wrapper for paginated Twitch API responses.
 *
 * Usage:
 * ```php
 * $raw = Twitch::getStreams();
 * $result = PaginatedResult::fromRaw($raw, Stream::class);
 *
 * foreach ($result->items as $stream) {
 *     echo $stream->userName; // Stream instance
 * }
 *
 * if ($result->hasMore()) {
 *     $next = Twitch::getStreams(after: $result->cursor);
 * }
 * ```
 *
 * @template T of Data
 */
class PaginatedResult
{
    /**
     * @param list<T>     $items  Hydrated DTO instances
     * @param string|null $cursor Cursor for the next page (null = no more pages)
     * @param int|null    $total  Total count (if provided by the API)
     */
    public function __construct(
        public readonly array $items,
        public readonly ?string $cursor,
        public readonly ?int $total = null,
    ) {}

    /**
     * Build a PaginatedResult from a raw Twitch API response array.
     *
     * @template TItem of Data
     *
     * @param array<string, mixed> $raw      Raw response from makeRequest()
     * @param class-string<TItem>  $dtoClass DTO class to hydrate each item
     *
     * @return self<TItem>
     */
    public static function fromRaw(array $raw, string $dtoClass): self
    {
        /** @var list<array<string, mixed>> $data */
        $data = $raw['data'] ?? [];

        $items = array_map(
            static fn (array $item): Data => $dtoClass::from($item),
            $data,
        );

        /** @var array{cursor?: string}|mixed $pagination */
        $pagination = $raw['pagination'] ?? [];
        $cursor     = is_array($pagination) ? ($pagination['cursor'] ?? null) : null;
        $total      = isset($raw['total']) && is_int($raw['total']) ? $raw['total'] : null;

        return new self(
            items: $items,
            cursor: is_string($cursor) ? $cursor : null,
            total: $total,
        );
    }

    /**
     * Number of items in the current page.
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Whether more pages are available.
     */
    public function hasMore(): bool
    {
        return null !== $this->cursor;
    }
}
