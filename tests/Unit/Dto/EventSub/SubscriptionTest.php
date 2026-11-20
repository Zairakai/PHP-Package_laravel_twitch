<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\EventSub;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\EventSub\Subscription;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class SubscriptionTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $subscription = Subscription::from([
            'id'         => 'sub-001',
            'type'       => 'stream.online',
            'version'    => '1',
            'status'     => 'enabled',
            'cost'       => 1,
            'condition'  => [
                'broadcaster_user_id' => '12345',
            ],
            'transport'  => [
                'method'   => 'webhook',
                'callback' => 'https://example.com/hook',
            ],
            'created_at' => '2024-01-01T00:00:00Z',
        ]);

        self::assertSame('sub-001', $subscription->id);
        self::assertSame('stream.online', $subscription->type);
        self::assertSame('1', $subscription->version);
        self::assertSame('enabled', $subscription->status);
        self::assertSame(1, $subscription->cost);
        self::assertSame([
            'broadcaster_user_id' => '12345',
        ], $subscription->condition);
        self::assertSame('webhook', $subscription->transport['method']);
        self::assertInstanceOf(Carbon::class, $subscription->createdAt);
    }

    #[Test]
    public function it_casts_created_at_with_fractional_seconds_to_carbon(): void
    {
        // Real Twitch payloads use variable-precision fractional seconds
        // (microsecond here) that spatie/laravel-data's default
        // DateTimeInterfaceCast rejects outright - FlexibleDateTimeCast must
        // be applied, same as every other EventSub timestamp field.
        $subscription = Subscription::from([
            'id'         => 'sub-002',
            'type'       => 'channel.chat.message',
            'version'    => '1',
            'status'     => 'enabled',
            'cost'       => 0,
            'condition'  => [
                'broadcaster_user_id' => '12345',
            ],
            'transport'  => [
                'method'   => 'webhook',
                'callback' => 'https://example.com/hook',
            ],
            'created_at' => '2020-07-15T17:16:03.171067Z',
        ]);

        self::assertInstanceOf(Carbon::class, $subscription->createdAt);
        self::assertSame('2020-07-15 17:16:03', $subscription->createdAt->toDateTimeString());
    }
}
