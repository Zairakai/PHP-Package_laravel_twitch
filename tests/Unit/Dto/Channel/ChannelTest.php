<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Channel;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Channel\Channel;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class ChannelTest extends TestCase
{
    #[Test]
    public function it_can_be_created_from_raw_array(): void
    {
        $channel = Channel::from([
            'broadcaster_id'                => '98765',
            'broadcaster_login'             => 'twitchdev',
            'broadcaster_name'              => 'TwitchDev',
            'broadcaster_language'          => 'en',
            'game_id'                       => '21779',
            'game_name'                     => 'League of Legends',
            'title'                         => 'Playing ranked!',
            'delay'                         => 0,
            'is_branded_content'            => false,
            'tags'                          => ['FPS', 'Competitive'],
            'content_classification_labels' => ['MatureGame'],
        ]);

        $this->assertSame('98765', $channel->broadcasterId);
        $this->assertSame('twitchdev', $channel->broadcasterLogin);
        $this->assertSame('en', $channel->broadcasterLanguage);
        $this->assertSame('21779', $channel->gameId);
        $this->assertSame('League of Legends', $channel->gameName);
        $this->assertSame('Playing ranked!', $channel->title);
        $this->assertSame(0, $channel->delay);
        $this->assertFalse($channel->isBrandedContent);
        $this->assertSame(['FPS', 'Competitive'], $channel->tags);
        $this->assertSame(['MatureGame'], $channel->contentClassificationLabels);
    }

    #[Test]
    public function it_defaults_arrays_to_empty(): void
    {
        $channel = Channel::from([
            'broadcaster_id'       => '11111',
            'broadcaster_login'    => 'user',
            'broadcaster_name'     => 'User',
            'broadcaster_language' => 'fr',
            'game_id'              => '',
            'game_name'            => '',
            'title'                => '',
            'delay'                => 0,
            'is_branded_content'   => false,
        ]);

        $this->assertSame([], $channel->tags);
        $this->assertSame([], $channel->contentClassificationLabels);
    }
}
