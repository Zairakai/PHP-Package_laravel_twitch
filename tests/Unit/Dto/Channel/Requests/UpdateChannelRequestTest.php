<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Channel\Requests;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Channel\Requests\UpdateChannelRequest;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class UpdateChannelRequestTest extends TestCase
{
    #[Test]
    public function it_can_be_constructed_with_all_nulls(): void
    {
        $updateChannelRequest = new UpdateChannelRequest();

        $this->assertNull($updateChannelRequest->gameId);
        $this->assertNull($updateChannelRequest->title);
        $this->assertNull($updateChannelRequest->tags);
    }

    #[Test]
    public function it_serializes_to_snake_case_for_the_api(): void
    {
        $updateChannelRequest = new UpdateChannelRequest(
            gameId: '21779',
            broadcasterLanguage: 'en',
            title: 'Playing ranked!',
            isBrandedContent: false,
        );

        $array = $updateChannelRequest->toArray();

        $this->assertSame('21779', $array['game_id']);
        $this->assertSame('en', $array['broadcaster_language']);
        $this->assertSame('Playing ranked!', $array['title']);
        $this->assertFalse($array['is_branded_content']);
    }
}
