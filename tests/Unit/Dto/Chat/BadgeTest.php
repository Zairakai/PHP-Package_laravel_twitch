<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Chat;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Chat\Badge;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class BadgeTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $badge = Badge::from([
            'set_id'   => 'subscriber',
            'versions' => [
                ['id' => '0', 'image_url_1x' => 'https://example.com/1x.png', 'image_url_2x' => 'https://example.com/2x.png', 'image_url_4x' => 'https://example.com/4x.png', 'title' => 'Subscriber', 'description' => 'subscriber', 'click_action' => null, 'click_url' => null],
            ],
        ]);

        $this->assertSame('subscriber', $badge->setId);
        $this->assertCount(1, $badge->versions);
        $this->assertSame('0', $badge->versions[0]['id']);
        $this->assertSame('Subscriber', $badge->versions[0]['title']);
    }
}
