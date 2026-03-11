<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasExtensionsMethodsTest extends TestCase
{
    // ── getExtensionLiveChannels ───────────────────────────────────────────────

    #[Test]
    public function it_calls_the_extension_live_channels_endpoint(): void
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

        $service->getExtensionLiveChannels('ext-1');

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/extensions/live', $capturedParams['endpoint']);
    }

    // ── getExtension ──────────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_extensions_endpoint(): void
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

        $service->getExtension('ext-1');

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/extensions', $capturedParams['endpoint']);
    }

    #[Test]
    public function it_exercises_all_extensions_wrappers_with_real_endpoint_calls(): void
    {
        $service = new class('client-id', 'secret') extends TwitchApiService
        {
            /**
             * @var list<array{method: string, endpoint: string, params: array<string, mixed>}>
             */
            public array $calls = [];

            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                $this->calls[] = [
                    'method'   => $method,
                    'endpoint' => $endpoint,
                    'params'   => $params,
                ];

                return ['data' => [], 'pagination' => []];
            }
        };

        $service->createExtensionSecret('ext-1', 600);
        $service->getExtension('ext-1', '1.0.0');
        $service->getExtensionBitsProducts('ext-client', true);
        $service->getExtensionConfigurationSegment('ext-1', 'broadcaster', '123');
        $service->getExtensionLiveChannels('ext-1', 10, 'cursor-1');
        $service->getExtensionSecrets('ext-1');
        $service->getReleasedExtension('ext-1', '1.0.0');
        $service->sendExtensionChatMessage('123', 'ext-1', '1.0.0', 'hello');
        $service->sendExtensionPubSubMessage('123', 'ext-1', 'payload', ['broadcast']);
        $service->setExtensionConfigurationSegment('ext-1', 'global', '123', '{"enabled":true}', 'v2');
        $service->setExtensionRequiredConfiguration('123', 'ext-1', '1.0.0', 'v2');
        $service->updateExtensionBitsProduct('ext-client', ['sku' => 'item-1']);

        $this->assertCount(12, $service->calls);
        $this->assertSame('/extensions/jwt/secrets', $service->calls[0]['endpoint']);
        $this->assertSame('/bits/extensions', $service->calls[2]['endpoint']);
        $this->assertSame('/extensions/configurations', $service->calls[9]['endpoint']);
        $this->assertSame('/bits/extensions', $service->calls[11]['endpoint']);
    }

    #[Test]
    public function it_returns_an_array_for_get_extension(): void
    {
        $service = new class('client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                return ['data' => [['extension_id' => 'ext-1', 'name' => 'My Extension']]];
            }
        };

        $result = $service->getExtension('ext-1');

        $this->assertArrayHasKey('data', $result);
    }

    #[Test]
    public function it_returns_an_array_for_get_extension_live_channels(): void
    {
        $service = new class('client-id', 'secret') extends TwitchApiService
        {
            /**
             * @param array<string, mixed> $params
             */
            protected function makeRequest(string $method, string $endpoint, array $params = []): array
            {
                return ['data' => []];
            }
        };

        $result = $service->getExtensionLiveChannels('ext-1');

        $this->assertArrayHasKey('data', $result);
    }
}
