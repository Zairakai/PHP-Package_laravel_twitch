<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasChannelMethodsTest extends TestCase
{
    #[Test]
    public function it_calls_the_icalendar_endpoint_with_broadcaster_id(): void
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
            protected function makeRawRequest(string $method, string $endpoint, array $params = []): string
            {
                $this->captured = ['method' => $method, 'endpoint' => $endpoint, 'params' => $params];

                return '';
            }
        };

        $service->getScheduleCalendar('99999');

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/schedule/icalendar', $capturedParams['endpoint']);
        $this->assertSame(['broadcaster_id' => '99999'], $capturedParams['params']);
    }

    #[Test]
    public function it_exercises_channel_wrappers_for_collections_search_and_deletion(): void
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

                return '/schedule' === $endpoint
                    ? ['data' => [
                        'broadcaster_id'    => '99999',
                        'broadcaster_name'  => 'Zairakai',
                        'broadcaster_login' => 'zairakai',
                        'segments'          => [],
                    ]]
                    : ['data' => [], 'pagination' => []];
            }

            /**
             * @param array<string, mixed> $params
             */
            protected function makeRawRequest(string $method, string $endpoint, array $params = []): string
            {
                $this->calls[] = [
                    'method'   => $method,
                    'endpoint' => $endpoint,
                    'params'   => $params,
                ];

                return "BEGIN:VCALENDAR\r\nEND:VCALENDAR";
            }
        };

        $service->deleteScheduleSegment('b-1', 'seg-1');
        $service->getChannel(['b-1', 'b-2']);
        $service->getChannelEditors('b-1');
        $service->getSchedule('b-1', null, 5, 'cur-1');
        $service->getScheduleCalendar('b-1');
        $service->searchChannels('zairakai', 5, 'cur-2', true);

        $this->assertCount(6, $service->calls);
        $this->assertSame('/schedule/segment', $service->calls[0]['endpoint']);
        $this->assertSame('/schedule/icalendar', $service->calls[4]['endpoint']);
        $this->assertSame('/search/channels', $service->calls[5]['endpoint']);
    }

    // ── getScheduleCalendar ───────────────────────────────────────────────────

    #[Test]
    public function it_returns_icalendar_content_as_a_string(): void
    {
        $ical = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nPRODID:-//Twitch//EN\r\nEND:VCALENDAR";

        $service = new class($ical, 'client-id', 'secret') extends TwitchApiService
        {
            public function __construct(
                private readonly string $ical,
                string $clientId,
                string $clientSecret,
            ) {
                parent::__construct($clientId, $clientSecret);
            }

            /**
             * @param array<string, mixed> $params
             */
            protected function makeRawRequest(string $method, string $endpoint, array $params = []): string
            {
                return $this->ical;
            }
        };

        $result = $service->getScheduleCalendar('12345');

        $this->assertIsString($result);
        $this->assertStringContainsString('BEGIN:VCALENDAR', $result);
        $this->assertStringContainsString('END:VCALENDAR', $result);
    }
}
