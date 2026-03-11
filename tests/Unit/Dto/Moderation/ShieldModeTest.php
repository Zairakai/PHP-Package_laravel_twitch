<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Moderation;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Moderation\ShieldMode;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class ShieldModeTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $shieldMode = ShieldMode::from([
            'is_active'          => true,
            'moderator_id'       => '67890',
            'moderator_login'    => 'moduser',
            'moderator_name'     => 'ModUser',
            'last_activated_at'  => '2024-03-01T10:00:00Z',
        ]);

        $this->assertTrue($shieldMode->isActive);
        $this->assertSame('67890', $shieldMode->moderatorId);
        $this->assertSame('2024-03-01T10:00:00Z', $shieldMode->lastActivatedAt);
    }

    #[Test]
    public function it_handles_inactive_shield_with_null_activation(): void
    {
        $shieldMode = ShieldMode::from([
            'is_active'       => false,
            'moderator_id'    => '67890',
            'moderator_login' => 'moduser',
            'moderator_name'  => 'ModUser',
        ]);

        $this->assertFalse($shieldMode->isActive);
        $this->assertNull($shieldMode->lastActivatedAt);
    }
}
