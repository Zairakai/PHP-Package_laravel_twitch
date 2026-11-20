<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;
use Zairakai\LaravelTwitch\Dto\Users\User;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class PaginatedResultTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_response(): void
    {
        $raw = [
            'data' => [
                [
                    'id'                => '12345',
                    'login'             => 'zairakai',
                    'display_name'      => 'Zairakai',
                    'type'              => '',
                    'broadcaster_type'  => 'partner',
                    'description'       => 'Test',
                    'profile_image_url' => 'http://example.com/img.jpg',
                    'offline_image_url' => 'http://example.com/offline.jpg',
                    'view_count'        => 1000,
                    'created_at'        => '2021-01-01T00:00:00Z',
                ],
            ],
            'pagination' => [
                'cursor' => 'cursor-123',
            ],
            'total' => 1,
        ];

        $paginatedResult = PaginatedResult::fromRaw($raw, User::class);

        self::assertCount(1, $paginatedResult->items);
        self::assertSame('12345', $paginatedResult->items[0]->id);
        self::assertSame('cursor-123', $paginatedResult->cursor);
        self::assertTrue($paginatedResult->hasMore());
        self::assertSame(1, $paginatedResult->total);
        self::assertSame(1, $paginatedResult->count());
    }

    #[Test]
    public function it_handles_empty_response(): void
    {
        $raw = [];

        $paginatedResult = PaginatedResult::fromRaw($raw, User::class);

        self::assertEmpty($paginatedResult->items);
        self::assertNull($paginatedResult->cursor);
        self::assertFalse($paginatedResult->hasMore());
        self::assertNull($paginatedResult->total);
        self::assertSame(0, $paginatedResult->count());
    }

    #[Test]
    public function it_handles_missing_pagination(): void
    {
        $raw = [
            'data' => [
                [
                    'id'                => '12345',
                    'login'             => 'zairakai',
                    'display_name'      => 'Zairakai',
                    'type'              => '',
                    'broadcaster_type'  => 'partner',
                    'description'       => 'Test',
                    'profile_image_url' => 'http://example.com/img.jpg',
                    'offline_image_url' => 'http://example.com/offline.jpg',
                    'view_count'        => 1000,
                    'created_at'        => '2021-01-01T00:00:00Z',
                ],
            ],
        ];

        $paginatedResult = PaginatedResult::fromRaw($raw, User::class);

        self::assertCount(1, $paginatedResult->items);
        self::assertNull($paginatedResult->cursor);
        self::assertFalse($paginatedResult->hasMore());
    }
}
