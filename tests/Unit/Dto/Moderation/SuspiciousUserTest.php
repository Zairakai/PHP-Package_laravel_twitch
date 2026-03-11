<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Moderation;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Moderation\SuspiciousUser;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class SuspiciousUserTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $suspiciousUser = SuspiciousUser::from([
            'broadcaster_id'         => '12345',
            'moderator_id'           => '67890',
            'user_id'                => '11111',
            'user_login'             => 'suspicious',
            'user_name'              => 'Suspicious',
            'low_trust_status'       => 'restricted',
            'types'                  => ['ban_evader_detector'],
            'shared_ban_channel_ids' => ['22222', '33333'],
            'ban_evasion_evaluation' => 'likely',
            'created_at'             => '2024-01-01T00:00:00Z',
            'updated_at'             => '2024-01-02T00:00:00Z',
        ]);

        $this->assertSame('11111', $suspiciousUser->userId);
        $this->assertSame('restricted', $suspiciousUser->lowTrustStatus);
        $this->assertSame(['ban_evader_detector'], $suspiciousUser->types);
        $this->assertSame(['22222', '33333'], $suspiciousUser->sharedBanChannelIds);
        $this->assertSame('likely', $suspiciousUser->banEvasionEvaluation);
        $this->assertSame('2024-01-01T00:00:00Z', $suspiciousUser->createdAt);
    }

    #[Test]
    public function it_uses_default_values_when_fields_are_absent(): void
    {
        $suspiciousUser = SuspiciousUser::from([
            'broadcaster_id'   => '12345',
            'moderator_id'     => '67890',
            'user_id'          => '11111',
            'user_login'       => 'suspicious',
            'user_name'        => 'Suspicious',
            'low_trust_status' => 'active_monitoring',
        ]);

        $this->assertSame([], $suspiciousUser->types);
        $this->assertSame([], $suspiciousUser->sharedBanChannelIds);
        $this->assertSame('unknown', $suspiciousUser->banEvasionEvaluation);
        $this->assertNull($suspiciousUser->createdAt);
    }
}
