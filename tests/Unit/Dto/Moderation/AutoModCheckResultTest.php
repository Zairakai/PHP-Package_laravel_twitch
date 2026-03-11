<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Moderation;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Moderation\AutoModCheckResult;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class AutoModCheckResultTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $autoModCheckResult = AutoModCheckResult::from([
            'msg_id'       => 'msg-001',
            'is_permitted' => true,
        ]);

        $this->assertSame('msg-001', $autoModCheckResult->msgId);
        $this->assertTrue($autoModCheckResult->isPermitted);
    }
}
