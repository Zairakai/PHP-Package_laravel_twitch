<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Drops;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Drops\DropsEntitlement;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class DropsEntitlementTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $dropsEntitlement = DropsEntitlement::from([
            'id'                 => 'ent-001',
            'benefit_id'         => 'benefit-abc',
            'user_id'            => '12345',
            'game_id'            => '67890',
            'fulfillment_status' => 'CLAIMED',
            'timestamp'          => '2024-01-15T12:00:00Z',
            'updated_at'         => '2024-01-16T08:30:00Z',
        ]);

        self::assertSame('ent-001', $dropsEntitlement->id);
        self::assertSame('benefit-abc', $dropsEntitlement->benefitId);
        self::assertSame('12345', $dropsEntitlement->userId);
        self::assertSame('67890', $dropsEntitlement->gameId);
        self::assertSame('CLAIMED', $dropsEntitlement->fulfillmentStatus);
        self::assertInstanceOf(Carbon::class, $dropsEntitlement->timestamp);
        self::assertSame('2024-01-15 12:00:00', $dropsEntitlement->timestamp->toDateTimeString());
        self::assertInstanceOf(Carbon::class, $dropsEntitlement->updatedAt);
        self::assertSame('2024-01-16 08:30:00', $dropsEntitlement->updatedAt->toDateTimeString());
    }

    #[Test]
    public function it_handles_null_dates(): void
    {
        $dropsEntitlement = DropsEntitlement::from([
            'id'                 => 'ent-002',
            'benefit_id'         => 'benefit-xyz',
            'user_id'            => '99999',
            'game_id'            => '11111',
            'fulfillment_status' => 'UNFULFILLED',
        ]);

        self::assertSame('ent-002', $dropsEntitlement->id);
        self::assertSame('UNFULFILLED', $dropsEntitlement->fulfillmentStatus);
        self::assertNull($dropsEntitlement->timestamp);
        self::assertNull($dropsEntitlement->updatedAt);
    }
}
