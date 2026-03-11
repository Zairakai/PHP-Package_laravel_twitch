<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Moderation\Requests;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Moderation\Requests\UpdateAutoModSettingsRequest;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class UpdateAutoModSettingsRequestTest extends TestCase
{
    #[Test]
    public function it_serializes_to_snake_case_for_the_api(): void
    {
        $updateAutoModSettingsRequest = new UpdateAutoModSettingsRequest(
            overallLevel: 3,
            aggression: 2,
            swearing: 1,
        );

        $array = $updateAutoModSettingsRequest->toArray();

        $this->assertSame(3, $array['overall_level']);
        $this->assertSame(2, $array['aggression']);
        $this->assertSame(1, $array['swearing']);
    }
}
