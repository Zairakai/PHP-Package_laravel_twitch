<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Moderation\Requests;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Moderation\Requests\AutoModMessageRequest;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class AutoModMessageRequestTest extends TestCase
{
    #[Test]
    public function it_serializes_to_snake_case_for_the_api(): void
    {
        $autoModMessageRequest = new AutoModMessageRequest(
            msgId: 'msg-001',
            msgText: 'Is this message okay?',
        );

        $array = $autoModMessageRequest->toArray();

        $this->assertSame('msg-001', $array['msg_id']);
        $this->assertSame('Is this message okay?', $array['msg_text']);
    }
}
