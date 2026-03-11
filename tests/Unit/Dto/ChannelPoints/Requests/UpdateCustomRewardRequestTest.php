<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\ChannelPoints\Requests;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\ChannelPoints\Requests\UpdateCustomRewardRequest;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class UpdateCustomRewardRequestTest extends TestCase
{
    #[Test]
    public function it_serializes_to_snake_case_for_the_api(): void
    {
        $updateCustomRewardRequest = new UpdateCustomRewardRequest(
            title: 'New title',
            cost: 1000,
            isPaused: true,
        );

        $array = $updateCustomRewardRequest->toArray();

        $this->assertSame('New title', $array['title']);
        $this->assertSame(1000, $array['cost']);
        $this->assertTrue($array['is_paused']);
    }
}
