<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\ChannelPoints\Requests;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\ChannelPoints\Requests\CreateCustomRewardRequest;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class CreateCustomRewardRequestTest extends TestCase
{
    #[Test]
    public function it_serializes_to_snake_case_for_the_api(): void
    {
        $createCustomRewardRequest = new CreateCustomRewardRequest(
            title: 'Hydrate!',
            cost: 500,
            isEnabled: true,
            isUserInputRequired: false,
        );

        $array = $createCustomRewardRequest->toArray();

        self::assertSame('Hydrate!', $array['title']);
        self::assertSame(500, $array['cost']);
        self::assertTrue($array['is_enabled']);
        self::assertFalse($array['is_user_input_required']);
    }
}
