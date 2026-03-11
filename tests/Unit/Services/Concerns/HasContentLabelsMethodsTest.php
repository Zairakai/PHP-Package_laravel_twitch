<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Spatie\LaravelData\DataCollection;
use Zairakai\LaravelTwitch\Dto\ContentLabels\ContentClassificationLabel;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasContentLabelsMethodsTest extends TestCase
{
    // ── getContentClassificationLabels ────────────────────────────────────────

    #[Test]
    public function it_calls_the_content_classification_labels_endpoint(): void
    {
        $capturedParams = null;

        $service = new class('client-id', 'secret', $capturedParams) extends TwitchApiService
        {
            public function __construct(
                string $clientId,
                string $clientSecret,
                public mixed &$captured,
            ) {
                parent::__construct($clientId, $clientSecret);
            }

            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                $this->captured = ['method' => $method, 'endpoint' => $endpoint, 'params' => $params];

                return ['data' => []];
            }
        };

        $service->getContentClassificationLabels();

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/content_classification_labels', $capturedParams['endpoint']);
    }

    #[Test]
    public function it_returns_a_data_collection_of_content_classification_labels(): void
    {
        $service = new class('client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                return [
                    'data' => [
                        [
                            'id'          => 'DrugsIntoxication',
                            'description' => 'Drug use',
                            'name'        => 'Drugs, Intoxicants & Related Paraphernalia',
                        ],
                    ],
                ];
            }
        };

        $dataCollection = $service->getContentClassificationLabels();

        $this->assertInstanceOf(DataCollection::class, $dataCollection);
        $this->assertInstanceOf(ContentClassificationLabel::class, $dataCollection->first());
        $this->assertSame('DrugsIntoxication', $dataCollection->first()->id);
        $this->assertSame('Drug use', $dataCollection->first()->description);
    }
}
