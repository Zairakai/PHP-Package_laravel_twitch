<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Dto\EventSub;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\GenericEventSubEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\EventSubEventFactory;
use Zairakai\LaravelTwitch\Tests\TestCase;

/**
 * Round-trips every mapped EventSub type through the factory using the exact
 * example payload published on dev.twitch.tv/docs/eventsub/eventsub-subscription-types
 * (fetched 2026-08-09) - proves each generated DTO actually constructs from a
 * real Twitch payload, not just that it compiles.
 */
final class EventSubEventFactoryRealPayloadsTest extends TestCase
{
    /**
     * @return iterable<string, array{0: string}>
     */
    public static function mappedTypes(): iterable
    {
        /** @var array<string, string> $fixtures */
        $fixtures = require __DIR__ . '/../../../Fixtures/eventsub_examples.php';

        foreach (array_keys($fixtures) as $type) {
            yield $type => [$type];
        }
    }

    #[Test]
    #[DataProvider('mappedTypes')]
    public function it_constructs_the_mapped_dto_from_the_official_example_payload(string $type): void
    {
        /** @var array<string, string> $fixtures */
        $fixtures = require __DIR__ . '/../../../Fixtures/eventsub_examples.php';

        $raw = $fixtures[$type];

        // Strip the // comments Twitch's docs embed in their JSON examples, and
        // the trailing commas that removing them leaves behind.
        $cleaned = preg_replace('/(?<=\s)\/\/[^\n]*/', '', $raw);
        $cleaned = preg_replace('/,(\s*[}\]])/', '$1', (string) $cleaned);

        /** @var array<string, mixed>|null $payload */
        $payload = json_decode((string) $cleaned, true);

        $this->assertIsArray($payload, "Fixture for {$type} is not valid JSON once cleaned.");

        $event = EventSubEventFactory::make($type, $payload);

        $this->assertNotInstanceOf(
            GenericEventSubEvent::class,
            $event,
            "{$type} is expected to resolve to a dedicated DTO, not the generic fallback.",
        );
    }

    #[Test]
    public function it_falls_back_to_generic_event_for_a_type_with_no_dedicated_dto(): void
    {
        $eventSubEvent = EventSubEventFactory::make('channel.some_future_type', ['id' => '1']);

        $this->assertInstanceOf(GenericEventSubEvent::class, $eventSubEvent);
    }
}
