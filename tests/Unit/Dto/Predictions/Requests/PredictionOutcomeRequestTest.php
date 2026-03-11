<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Predictions\Requests;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Predictions\Requests\PredictionOutcomeRequest;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class PredictionOutcomeRequestTest extends TestCase
{
    #[Test]
    public function it_serializes_for_the_api(): void
    {
        $predictionOutcomeRequest = new PredictionOutcomeRequest(title: 'Team A wins');

        $array = $predictionOutcomeRequest->toArray();

        $this->assertSame('Team A wins', $array['title']);
    }
}
