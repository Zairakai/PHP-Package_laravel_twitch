<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\Predictions\Requests;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Predictions\Requests\CreatePredictionRequest;
use Zairakai\LaravelTwitch\Dto\Predictions\Requests\PredictionOutcomeRequest;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class CreatePredictionRequestTest extends TestCase
{
    #[Test]
    public function it_serializes_to_snake_case_for_the_api(): void
    {
        $createPredictionRequest = new CreatePredictionRequest(
            broadcasterId: '12345',
            title: 'Will we win?',
            outcomes: [new PredictionOutcomeRequest(title: 'Yes'), new PredictionOutcomeRequest(title: 'No')],
            predictionWindow: 120,
        );

        $array = $createPredictionRequest->toArray();

        $this->assertSame('12345', $array['broadcaster_id']);
        $this->assertSame('Will we win?', $array['title']);
        $this->assertSame(120, $array['prediction_window']);
    }
}
