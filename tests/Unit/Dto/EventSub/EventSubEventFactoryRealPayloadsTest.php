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

    /**
     * Charity campaign types using the non-standard `broadcaster_id` field
     * (Twitch's own docs inconsistency) - `channel.charity_campaign.donate`
     * is not one of them, it uses the standard `broadcaster_user_id`.
     *
     * @return list<string>
     */
    public static function typesWithBroadcasterIdField(): array
    {
        return [
            'channel.charity_campaign.start',
            'channel.charity_campaign.progress',
            'channel.charity_campaign.stop',
        ];
    }

    /**
     * Types with no single channel owner - user-scoped or app-scoped
     * notifications where getBroadcasterUserId() is expected to return null.
     *
     * @return list<string>
     */
    public static function typesWithNoBroadcaster(): array
    {
        return [
            'conduit.shard.disabled',
            'user.authorization.grant',
            'user.authorization.revoke',
            'user.update',
            'user.whisper.message',
        ];
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

    #[Test]
    #[DataProvider('mappedTypes')]
    public function it_resolves_the_expected_broadcaster_user_id_for_each_type(string $type): void
    {
        /** @var array<string, string> $fixtures */
        $fixtures = require __DIR__ . '/../../../Fixtures/eventsub_examples.php';

        $cleaned = preg_replace('/(?<=\s)\/\/[^\n]*/', '', $fixtures[$type]);
        $cleaned = preg_replace('/,(\s*[}\]])/', '$1', (string) $cleaned);

        /** @var array<string, mixed> $payload */
        $payload = json_decode((string) $cleaned, true);

        $event = EventSubEventFactory::make($type, $payload);

        $expected = match (true) {
            in_array($type, self::typesWithNoBroadcaster(), true)      => null,
            'channel.raid' === $type                                   => $payload['to_broadcaster_user_id'],
            in_array($type, self::typesWithBroadcasterIdField(), true) => $payload['broadcaster_id'],
            'automod.settings.update' === $type                        => $payload['data'][0]['broadcaster_user_id'],
            default                                                    => $payload['broadcaster_user_id'] ?? null,
        };

        $this->assertSame(
            $expected,
            $event->getBroadcasterUserId(),
            "Unexpected getBroadcasterUserId() for {$type}.",
        );
    }
}
