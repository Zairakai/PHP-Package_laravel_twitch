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
            'tags'                          => [
                'FPS',
                'Competitive',
            ],
            'content_classification_labels' => [
                'MatureGame',
            ],
        ]);

        self::assertSame('98765', $channel->broadcasterId);
        self::assertSame('twitchdev', $channel->broadcasterLogin);
        self::assertSame('en', $channel->broadcasterLanguage);
        self::assertSame('21779', $channel->gameId);
        self::assertSame('League of Legends', $channel->gameName);
        self::assertSame('Playing ranked!', $channel->title);
        self::assertSame(0, $channel->delay);
        self::assertFalse($channel->isBrandedContent);
        self::assertSame([
            'FPS',
            'Competitive',
        ], $channel->tags);
        self::assertSame([
            'MatureGame',
        ], $channel->contentClassificationLabels);
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

        self::assertSame([], $channel->tags);
        self::assertSame([], $channel->contentClassificationLabels);
    }
}
