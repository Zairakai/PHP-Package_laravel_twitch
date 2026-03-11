<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\ChannelPoints;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\ChannelPoints\CustomReward;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class CustomRewardTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $customReward = CustomReward::from([
            'broadcaster_id'                        => '12345',
            'broadcaster_login'                     => 'twitchdev',
            'broadcaster_name'                      => 'TwitchDev',
            'id'                                    => 'reward-abc',
            'title'                                 => 'Hydrate!',
            'prompt'                                => 'Remind me to drink water',
            'cost'                                  => 500,
            'background_color'                      => '#00E5CB',
            'is_enabled'                            => true,
            'is_user_input_required'                => false,
            'is_paused'                             => false,
            'is_in_stock'                           => true,
            'should_redemptions_skip_request_queue' => false,
        ]);

        $this->assertSame('reward-abc', $customReward->id);
        $this->assertSame('Hydrate!', $customReward->title);
        $this->assertSame(500, $customReward->cost);
        $this->assertSame('#00E5CB', $customReward->backgroundColor);
        $this->assertTrue($customReward->isEnabled);
        $this->assertFalse($customReward->isPaused);
        $this->assertTrue($customReward->isInStock);
        $this->assertNull($customReward->maxPerStreamSetting);
        $this->assertNull($customReward->cooldownExpiresAt);
    }
}
