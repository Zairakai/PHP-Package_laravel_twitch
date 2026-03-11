<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Chat\Requests;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Chat\Requests\UpdateChatSettingsRequest;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class UpdateChatSettingsRequestTest extends TestCase
{
    #[Test]
    public function it_serializes_to_snake_case_for_the_api(): void
    {
        $updateChatSettingsRequest = new UpdateChatSettingsRequest(
            emoteMode: true,
            followerMode: false,
            slowMode: true,
            slowModeWaitTime: 30,
        );

        $array = $updateChatSettingsRequest->toArray();

        $this->assertTrue($array['emote_mode']);
        $this->assertFalse($array['follower_mode']);
        $this->assertTrue($array['slow_mode']);
        $this->assertSame(30, $array['slow_mode_wait_time']);
    }
}
