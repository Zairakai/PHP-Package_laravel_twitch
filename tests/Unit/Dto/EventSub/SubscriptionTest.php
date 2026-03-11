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
            'condition'  => ['broadcaster_user_id' => '12345'],
            'transport'  => ['method' => 'webhook', 'callback' => 'https://example.com/hook'],
            'created_at' => '2024-01-01T00:00:00Z',
        ]);

        $this->assertSame('sub-001', $subscription->id);
        $this->assertSame('stream.online', $subscription->type);
        $this->assertSame('1', $subscription->version);
        $this->assertSame('enabled', $subscription->status);
        $this->assertSame(1, $subscription->cost);
        $this->assertSame(['broadcaster_user_id' => '12345'], $subscription->condition);
        $this->assertSame('webhook', $subscription->transport['method']);
        $this->assertInstanceOf(Carbon::class, $subscription->createdAt);
    }
}
