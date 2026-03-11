<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Ads;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Ads\CommercialResult;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class CommercialResultTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $commercialResult = CommercialResult::from([
            'length'      => 60,
            'message'     => '',
            'retry_after' => 480,
        ]);

        $this->assertSame(60, $commercialResult->length);
        $this->assertSame('', $commercialResult->message);
        $this->assertSame(480, $commercialResult->retryAfter);
    }
}
