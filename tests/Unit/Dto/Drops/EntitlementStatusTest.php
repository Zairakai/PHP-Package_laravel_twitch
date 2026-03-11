<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Drops;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Drops\EntitlementStatus;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class EntitlementStatusTest extends TestCase
{
    #[Test]
    public function it_can_be_created_with_ids(): void
    {
        $entitlementStatus = EntitlementStatus::from([
            'status' => 'CLAIMED',
            'ids'    => ['ent-001', 'ent-002', 'ent-003'],
        ]);

        $this->assertSame('CLAIMED', $entitlementStatus->status);
        $this->assertSame(['ent-001', 'ent-002', 'ent-003'], $entitlementStatus->ids);
    }

    #[Test]
    public function it_defaults_ids_to_empty_array(): void
    {
        $entitlementStatus = EntitlementStatus::from([
            'status' => 'UNFULFILLED',
        ]);

        $this->assertSame('UNFULFILLED', $entitlementStatus->status);
        $this->assertSame([], $entitlementStatus->ids);
    }
}
