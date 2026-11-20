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

        self::assertTrue($array['emote_mode']);
        self::assertFalse($array['follower_mode']);
        self::assertTrue($array['slow_mode']);
        self::assertSame(30, $array['slow_mode_wait_time']);
    }
}
