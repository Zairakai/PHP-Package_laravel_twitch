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
            'types'                  => [
                'ban_evader_detector',
            ],
            'shared_ban_channel_ids' => [
                '22222',
                '33333',
            ],
            'ban_evasion_evaluation' => 'likely',
            'created_at'             => '2024-01-01T00:00:00Z',
            'updated_at'             => '2024-01-02T00:00:00Z',
        ]);

        self::assertSame('11111', $suspiciousUser->userId);
        self::assertSame('restricted', $suspiciousUser->lowTrustStatus);
        self::assertSame([
            'ban_evader_detector',
        ], $suspiciousUser->types);
        self::assertSame([
            '22222',
            '33333',
        ], $suspiciousUser->sharedBanChannelIds);
        self::assertSame('likely', $suspiciousUser->banEvasionEvaluation);
        self::assertSame('2024-01-01T00:00:00Z', $suspiciousUser->createdAt);
    }

    #[Test]
    public function it_reads_the_answer_of_add_suspicious_status(): void
    {
        // Add / Remove Suspicious Status answer with `status` and no login, name or low_trust_status.
        $suspiciousUser = SuspiciousUser::from([
            'user_id'        => '3',
            'broadcaster_id' => '1',
            'moderator_id'   => '2',
            'updated_at'     => '2026-11-20T10:00:00.5Z',
            'status'         => 'ACTIVE_MONITORING',
            'types'          => [
                'MANUALLY_ADDED',
            ],
        ]);

        self::assertSame('ACTIVE_MONITORING', $suspiciousUser->status);
        self::assertNull($suspiciousUser->userLogin);
        self::assertNull($suspiciousUser->lowTrustStatus);
        self::assertSame([
            'MANUALLY_ADDED',
        ], $suspiciousUser->types);
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

        self::assertSame([], $suspiciousUser->types);
        self::assertSame([], $suspiciousUser->sharedBanChannelIds);
        self::assertSame('unknown', $suspiciousUser->banEvasionEvaluation);
        self::assertNull($suspiciousUser->createdAt);
    }
}
