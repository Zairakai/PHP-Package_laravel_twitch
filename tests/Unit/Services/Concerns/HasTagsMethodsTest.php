<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

/**
 * @deprecated Tests for the deprecated Tags API.
 */
final class HasTagsMethodsTest extends TestCase
{
    // ── getStreamTags ─────────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_stream_tags_endpoint(): void
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

        $service->getStreamTags('1');

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/streams/tags', $capturedParams['endpoint']);
        $this->assertSame(['broadcaster_id' => '1'], $capturedParams['params']);
    }

    // ── getAllStreamTags ───────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_tags_streams_endpoint(): void
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

        $service->getAllStreamTags();

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/tags/streams', $capturedParams['endpoint']);
    }

    #[Test]
    public function it_returns_an_array_for_get_all_stream_tags(): void
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

        $result = $service->getAllStreamTags();

        $this->assertArrayHasKey('data', $result);
    }
}
