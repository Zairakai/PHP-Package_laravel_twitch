<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Polls\Requests;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Polls\Requests\PollChoiceRequest;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class PollChoiceRequestTest extends TestCase
{
    #[Test]
    public function it_serializes_for_the_api(): void
    {
        $pollChoiceRequest = new PollChoiceRequest(title: 'Option A');

        $array = $pollChoiceRequest->toArray();

        $this->assertSame('Option A', $array['title']);
    }
}
