<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\DropEntitlementGrantEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\StreamOfflineEvent;
use Zairakai\LaravelTwitch\Http\Controllers\TwitchAuthController;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Services\TwitchOAuthService;
use Zairakai\LaravelTwitch\Tests\TestCase;

/**
 * How the webhook treats what Twitch delivers: replays, copies, versions and batches.
 */
final class WebhookDeliveryTest extends TestCase
{
    private TwitchAuthController $twitchAuthController;

    protected function setUp(): void
    {
        parent::setUp();

        $this->twitchAuthController = new TwitchAuthController(
            self::createStub(TwitchOAuthService::class),
            self::createStub(TwitchApiService::class),
        );

        config([
            'twitch.eventsub.webhook_secret' => 'my-secret',
        ]);
        Event::fake();
    }

    #[Test]
    public function it_accepts_an_old_message_when_the_age_check_is_off(): void
    {
        config([
            'twitch.eventsub.max_message_age' => null,
        ]);

        $response = $this->deliver(
            'stream.offline',
            $this->offline(),
            'msg-old',
            gmdate('Y-m-d\TH:i:s\Z', time() - 3600),
        );

        self::assertSame(200, $response->getStatusCode());
        Event::assertDispatched('twitch.stream.offline');
    }

    #[Test]
    public function it_answers_a_verification_challenge_every_time_it_is_asked(): void
    {
        // Twitch can ask again with the same message ID: a copy must not be answered with something else.
        $first  = $this->deliver('channel.follow', [
            'challenge'    => 'abc123',
            'subscription' => [
                'type' => 'channel.follow',
            ],
        ], 'msg-verify', null, null, 'webhook_callback_verification');
        $second = $this->deliver('channel.follow', [
            'challenge'    => 'abc123',
            'subscription' => [
                'type' => 'channel.follow',
            ],
        ], 'msg-verify', null, null, 'webhook_callback_verification');

        self::assertSame('abc123', $first->getContent());
        self::assertSame('abc123', $second->getContent());
    }

    #[Test]
    public function it_dispatches_a_batched_drop_notification(): void
    {
        $this->deliver('drop.entitlement.grant', [
            'subscription' => [
                'id'      => 's1',
                'type'    => 'drop.entitlement.grant',
                'version' => '1',
            ],
            'events'       => [
                [
                    'id'   => 'evt-1',
                    'data' => [
                        'organization_id' => 'org-1',
                        'category_id'     => 'cat-1',
                        'category_name'   => 'Fortnite',
                        'campaign_id'     => 'camp-1',
                        'user_id'         => '123',
                        'user_name'       => 'Cool_User',
                        'user_login'      => 'cool_user',
                        'entitlement_id'  => 'ent-1',
                        'benefit_id'      => 'ben-1',
                        'created_at'      => '2019-01-28T04:17:53.325Z',
                    ],
                ],
            ],
        ], 'msg-drop');

        Event::assertDispatched('twitch.drop.entitlement.grant', static fn (string $name, array $payload): bool => $payload[0] instanceof DropEntitlementGrantEvent
            && 1       === count($payload[0]->events)
            && 'ent-1' === $payload[0]->events[0]->data->entitlementId);
    }

    #[Test]
    public function it_falls_back_to_the_version_of_the_body(): void
    {
        // No version header: the body of the notification carries the version of the subscription.
        $this->deliver(
            'stream.offline',
            $this->offline(),
            'msg-v2',
        );

        Event::assertDispatched('twitch.stream.offline', static fn (string $name, array $payload): bool => '1' === $payload[1]);
    }

    #[Test]
    public function it_gives_the_version_from_the_header_to_the_listeners(): void
    {
        $this->deliver(
            'stream.offline',
            $this->offline(),
            'msg-v1',
            null,
            '2',
        );

        Event::assertDispatched('twitch.stream.offline', static fn (string $name, array $payload): bool => $payload[0] instanceof StreamOfflineEvent && '2' === $payload[1]);
    }

    #[Test]
    public function it_handles_a_message_id_only_once(): void
    {
        $first  = $this->deliver(
            'stream.offline',
            $this->offline(),
            'msg-dup',
        );
        $second = $this->deliver(
            'stream.offline',
            $this->offline(),
            'msg-dup',
        );

        self::assertSame(200, $first->getStatusCode());
        self::assertSame(200, $second->getStatusCode());
        Event::assertDispatchedTimes('twitch.stream.offline', 1);
    }

    #[Test]
    public function it_handles_every_copy_when_the_deduplication_is_off(): void
    {
        config([
            'twitch.eventsub.dedupe_ttl' => null,
        ]);

        $this->deliver(
            'stream.offline',
            $this->offline(),
            'msg-dup',
        );
        $this->deliver(
            'stream.offline',
            $this->offline(),
            'msg-dup',
        );

        Event::assertDispatchedTimes('twitch.stream.offline', 2);
    }

    #[Test]
    public function it_handles_two_different_messages(): void
    {
        $this->deliver(
            'stream.offline',
            $this->offline(),
            'msg-a',
        );
        $this->deliver(
            'stream.offline',
            $this->offline(),
            'msg-b',
        );

        Event::assertDispatchedTimes('twitch.stream.offline', 2);
    }

    #[Test]
    public function it_reads_a_timestamp_with_nanoseconds(): void
    {
        // Twitch sends RFC3339 with nine decimals.
        $response = $this->deliver(
            'stream.offline',
            $this->offline(),
            'msg-ns',
            gmdate('Y-m-d\TH:i:s') . '.634234626Z',
        );

        self::assertSame(200, $response->getStatusCode());
        Event::assertDispatched('twitch.stream.offline');
    }

    #[Test]
    public function it_refuses_a_signed_message_that_is_too_old(): void
    {
        $response = $this->deliver(
            'stream.offline',
            $this->offline(),
            'msg-old',
            gmdate('Y-m-d\TH:i:s\Z', time() - 3600),
        );

        self::assertSame(400, $response->getStatusCode());
        Event::assertNotDispatched('twitch.stream.offline');
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function deliver(
        string $type,
        array $payload,
        string $messageId,
        ?string $timestamp = null,
        ?string $version = null,
        string $messageType = 'notification',
    ): JsonResponse|Response {
        $body      = json_encode($payload, JSON_THROW_ON_ERROR);
        $timestamp ??= gmdate('Y-m-d\TH:i:s\Z');
        $signature = 'sha256=' . hash_hmac(
            'sha256',
            $messageId . $timestamp . $body,
            'my-secret',
        );

        $server = [
            'HTTP_TWITCH_EVENTSUB_MESSAGE_ID'        => $messageId,
            'HTTP_TWITCH_EVENTSUB_MESSAGE_TIMESTAMP' => $timestamp,
            'HTTP_TWITCH_EVENTSUB_MESSAGE_TYPE'      => $messageType,
            'HTTP_TWITCH_EVENTSUB_MESSAGE_SIGNATURE' => $signature,
            'HTTP_TWITCH_EVENTSUB_SUBSCRIPTION_TYPE' => $type,
            'CONTENT_TYPE'                           => 'application/json',
        ];

        if (null !== $version) {
            $server['HTTP_TWITCH_EVENTSUB_SUBSCRIPTION_VERSION'] = $version;
        }

        return $this->twitchAuthController->webhook(Request::create(
            '/twitch/webhook',
            'POST',
            [],
            [],
            [],
            $server,
            $body,
        ));
    }

    /**
     * @return array<string, mixed>
     */
    private function offline(): array
    {
        return [
            'subscription' => [
                'id'      => 's1',
                'type'    => 'stream.offline',
                'version' => '1',
            ],
            'event'        => [
                'id'                     => '40000000001',
                'broadcaster_user_id'    => '1',
                'broadcaster_user_login' => 'someone',
                'broadcaster_user_name'  => 'Someone',
            ],
        ];
    }
}
