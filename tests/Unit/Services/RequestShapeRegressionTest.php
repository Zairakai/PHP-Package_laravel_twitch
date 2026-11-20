<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\RequestInterface;
use ReflectionProperty;
use Zairakai\LaravelTwitch\Dto\Channel\Requests\CreateScheduleSegmentRequest;
use Zairakai\LaravelTwitch\Dto\Conduits\Requests\UpdateConduitShardRequest;
use Zairakai\LaravelTwitch\Dto\GuestStar\Requests\UpdateGuestStarSettingsRequest;
use Zairakai\LaravelTwitch\Dto\GuestStar\Requests\UpdateGuestStarSlotSettingsRequest;
use Zairakai\LaravelTwitch\Exceptions\ConduitShardsUpdateFailed;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

/**
 * What the package really sends to Twitch (through Guzzle, not through a stubbed makeRequest()).
 *
 * Each case was refused by the real API before it was fixed: see the comment of each test.
 */
final class RequestShapeRegressionTest extends TestCase
{
    /**
     * @var list<RequestInterface>
     */
    private array $requests = [];

    #[Test]
    public function it_asks_for_batching_on_a_batched_type(): void
    {
        $this->makeService($this->subscriptionResponse('drop.entitlement.grant', '1'))
            ->createEventSubSubscription('drop.entitlement.grant', [
                'organization_id' => 'org-1',
            ], 'https://example.com/hook', 'a-secret-of-ten-chars');

        self::assertTrue($this->sentBody()['is_batching_enabled']);
    }

    #[Test]
    public function it_fills_in_the_broadcaster_of_the_guest_star_settings(): void
    {
        // Twitch does not send broadcaster_id back, and sends a null token to a caller who is not the broadcaster.
        $settings = $this->makeService(new Response(200, [], json_encode([
            'data' => [
                [
                    'is_moderator_send_live_enabled'  => true,
                    'slot_count'                      => 4,
                    'is_browser_source_audio_enabled' => false,
                    'group_layout'                    => 'TILED',
                    'browser_source_token'            => null,
                ],
            ],
        ], JSON_THROW_ON_ERROR)))->getChannelGuestStarSettings('111', '222');

        self::assertSame('111', $settings->broadcasterId);
        self::assertSame(4, $settings->slotCount);
        self::assertNull($settings->browserSourceToken);
    }

    #[Test]
    public function it_filters_clips_by_broadcaster(): void
    {
        $this->makeService(new Response(
            200,
            [],
            '{"data":[]}',
        ))->getClips('111');

        $query = $this->sentQuery();

        self::assertSame('111', $query['broadcaster_id']);
        self::assertArrayNotHasKey('game_id', $query);
        self::assertArrayNotHasKey('id', $query);
    }

    #[Test]
    public function it_filters_clips_by_game_without_a_broadcaster(): void
    {
        $this->makeService(new Response(
            200,
            [],
            '{"data":[]}',
        ))->getClips(gameId: '509658', isFeatured: true);

        $query = $this->sentQuery();

        self::assertSame('509658', $query['game_id']);
        self::assertSame('true', $query['is_featured']);
        self::assertArrayNotHasKey('broadcaster_id', $query);
    }

    #[Test]
    public function it_filters_the_blocked_users_and_gives_a_source_context(): void
    {
        $this->makeService(new Response(
            200,
            [],
            '{"data":[]}',
        ))->getUserBlocks('111', 20, null, [
            '1',
            '2',
        ]);

        self::assertSame([
            '1',
            '2',
        ], $this->sentQuery()['user_id']);

        $this->makeService(new Response(204))->blockUser(
            '333',
            'spam',
            'chat',
        );

        self::assertSame('chat', $this->sentBody()['source_context']);
    }

    #[Test]
    public function it_filters_the_eventsub_subscriptions_by_conduit(): void
    {
        $this->makeService(new Response(
            200,
            [],
            '{"data":[]}',
        ))->getEventSubSubscriptions(conduitId: 'conduit-1');

        self::assertSame('conduit-1', $this->sentQuery()['conduit_id']);
    }

    #[Test]
    public function it_keeps_the_version_the_caller_asks_for(): void
    {
        $this->makeService($this->subscriptionResponse('automod.message.hold', '1'))
            ->createEventSubSubscription('automod.message.hold', [
                'broadcaster_user_id' => '1',
                'moderator_user_id'   => '1',
            ], 'https://example.com/hook', 'a-secret-of-ten-chars', '1');

        self::assertSame('1', $this->sentBody()['version']);
    }

    #[Test]
    public function it_leaves_for_source_only_out_when_it_is_not_given(): void
    {
        $this->makeService(new Response(204))->sendAnnouncement(
            '111',
            '222',
            'hello',
        );

        self::assertArrayNotHasKey('for_source_only', $this->sentBody());
    }

    #[Test]
    public function it_lowercases_the_announcement_colour_given_by_the_caller(): void
    {
        $this->makeService(new Response(204))->sendAnnouncement(
            '111',
            '222',
            'hello',
            'BLUE',
        );

        self::assertSame('blue', $this->sentBody()['color']);
    }

    #[Test]
    public function it_names_the_required_configuration_field_as_the_reference_does(): void
    {
        $this->makeService(new Response(204))->setExtensionRequiredConfiguration(
            '111',
            'ext-1',
            '1.0.0',
            'config-string',
        );

        $body = $this->sentBody();

        self::assertSame('config-string', $body['required_configuration']);
        self::assertArrayNotHasKey('configuration_version', $body);
    }

    #[Test]
    public function it_never_sends_the_guest_slot_volume_that_twitch_dropped(): void
    {
        $this->makeService(new Response(204))->updateGuestStarSlotSettings(
            '111',
            '111',
            'session-1',
            '1',
            new UpdateGuestStarSlotSettingsRequest(isLive: true, volume: 50),
        );

        $body = $this->sentBody();

        self::assertTrue($body['is_live']);
        self::assertArrayNotHasKey('volume', $body);
    }

    #[Test]
    public function it_reads_the_segment_created_in_the_schedule_object(): void
    {
        // The schedule endpoints answer `data: {segments: [...]}` (an object): `data[0]` does not exist. The segment
        // used to be created, then the call failed with "Undefined array key 0".
        $segment = $this->makeService(new Response(200, [], json_encode([
            'data' => [
                'segments'          => [
                    [
                        'id'             => 'seg-1',
                        'start_time'     => '2026-11-25T10:00:00Z',
                        'end_time'       => '2026-11-25T10:30:00Z',
                        'title'          => 'laravel-twitch test segment',
                        'canceled_until' => null,
                        'category'       => null,
                        'is_recurring'   => false,
                    ],
                ],
                'broadcaster_id'    => '111',
                'broadcaster_name'  => 'Someone',
                'broadcaster_login' => 'someone',
                'vacation'          => null,
            ],
        ], JSON_THROW_ON_ERROR)))->createScheduleSegment('111', new CreateScheduleSegmentRequest(
            '2026-11-25T10:00:00Z',
            'Europe/Paris',
            30,
            false,
        ));

        self::assertSame('seg-1', $segment->id);
    }

    #[Test]
    public function it_refuses_a_conduit_shard_count_above_twenty_thousand(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->makeService()->updateConduit('conduit-1', 20001);
    }

    #[Test]
    public function it_refuses_a_conduit_without_shards_or_with_too_many(): void
    {
        $service = $this->makeService();

        $this->expectException(InvalidArgumentException::class);
        $service->createConduit(0);
    }

    #[Test]
    public function it_refuses_a_cursor_after_and_before_together(): void
    {
        // Twitch answers 400 when both are given.
        $this->expectException(InvalidArgumentException::class);

        $this->makeService()->getStreams(
            null,
            null,
            null,
            20,
            'after-cursor',
            null,
            null,
            'before-cursor',
        );
    }

    #[Test]
    public function it_refuses_clips_by_broadcaster_and_game_together(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->makeService()->getClips(
            '111',
            null,
            20,
            null,
            null,
            null,
            '509658',
        );
    }

    #[Test]
    public function it_refuses_clips_without_any_filter(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->makeService()->getClips();
    }

    #[Test]
    public function it_refuses_more_than_one_hundred_conduit_shards_in_a_request(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->makeService()->updateConduitShards('conduit-1', array_fill(0, 101, new UpdateConduitShardRequest('0', [
            'method'     => 'websocket',
            'session_id' => 'abc',
        ])));
    }

    #[Test]
    public function it_refuses_to_move_a_guest_star_slot_without_a_destination(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->makeService()->updateGuestStarSlot(
            '111',
            '222',
            'session',
            '1',
        );
    }

    #[Test]
    public function it_refuses_two_eventsub_filters_at_once(): void
    {
        // Twitch answers 400 "cannot specify more than one filter".
        $this->expectException(InvalidArgumentException::class);

        $this->makeService()->getEventSubSubscriptions('channel.follow', 'enabled');
    }

    #[Test]
    public function it_returns_null_when_the_broadcaster_is_not_in_a_shared_chat(): void
    {
        self::assertNull($this->makeService(new Response(
            200,
            [],
            '{"data":[]}',
        ))->getSharedChatSession('111'));
    }

    #[Test]
    public function it_returns_null_when_the_channel_has_no_charity_campaign(): void
    {
        // Twitch answers an empty list: the method used to fail with "Undefined array key 0".
        self::assertNull($this->makeService(new Response(
            200,
            [],
            '{"data":[]}',
        ))->getCharityCampaign('111'));
    }

    #[Test]
    public function it_returns_null_when_there_is_no_guest_star_session(): void
    {
        self::assertNull($this->makeService(new Response(
            200,
            [],
            '{"data":[]}',
        ))->getGuestStarSession('111', '111'));
    }

    #[Test]
    public function it_returns_the_shards_when_twitch_accepts_them_all(): void
    {
        $shards = $this->makeService(new Response(202, [], json_encode([
            'data' => [
                [
                    'id'        => '0',
                    'status'    => 'enabled',
                    'transport' => [
                        'method'     => 'websocket',
                        'session_id' => 'abc',
                    ],
                ],
            ],
        ], JSON_THROW_ON_ERROR)))->updateConduitShards('conduit-1', [
            new UpdateConduitShardRequest('0', [
                'method'     => 'websocket',
                'session_id' => 'abc',
            ]),
        ]);

        self::assertCount(1, $shards);
    }

    #[Test]
    public function it_sends_for_source_only_with_an_announcement_and_with_a_message(): void
    {
        $this->makeService(new Response(204))->sendAnnouncement(
            '111',
            '222',
            'hello',
            'blue',
            false,
        );

        self::assertFalse($this->sentBody()['for_source_only']);

        $this->makeService(new Response(
            200,
            [],
            '{"data":[{"message_id":"m1","is_sent":true,"drop_reason":null}]}',
        ))
            ->sendMessage(
                '111',
                '222',
                'hello',
                null,
                null,
                true,
            );

        self::assertTrue($this->sentBody()['for_source_only']);
    }

    #[Test]
    public function it_sends_only_the_clip_ids_when_they_are_given(): void
    {
        // Twitch answers 400 when broadcaster_id, game_id and id are mixed ("mutually exclusive").
        $this->makeService(new Response(
            200,
            [],
            '{"data":[]}',
        ))->getClips('111', [
            'c1',
            'c2',
        ], 5, 'cursor');

        $query = $this->sentQuery();

        self::assertSame([
            'c1',
            'c2',
        ], $query['id']);
        self::assertArrayNotHasKey('broadcaster_id', $query);
        self::assertArrayNotHasKey('first', $query);
        self::assertArrayNotHasKey('after', $query);
    }

    #[Test]
    public function it_sends_the_announcement_colour_in_lowercase_by_default(): void
    {
        // Twitch answers 400 ("value must be one of '', 'primary', 'purple', 'blue', 'green', 'orange'") to 'PRIMARY'.
        $this->makeService(new Response(204))->sendAnnouncement(
            '111',
            '222',
            'hello',
        );

        self::assertSame('primary', $this->sentBody()['color']);
    }

    #[Test]
    public function it_sends_the_bits_leaderboard_period_in_lowercase(): void
    {
        // Twitch answers 400 ("value must be one of 'day', 'week', 'month', 'year', 'all'") to 'ALL'.
        $this->makeService(new Response(
            200,
            [],
            '{"data":[],"date_range":{"started_at":"","ended_at":""},"total":0}',
        ))->getBitsLeaderboard();

        self::assertSame('all', $this->sentQuery()['period']);

        $this->makeService(new Response(
            200,
            [],
            '{"data":[],"date_range":{"started_at":"","ended_at":""},"total":0}',
        ))->getBitsLeaderboard(
            5,
            'WEEK',
            null,
            '2026-11-01T00:00:00Z',
        );

        self::assertSame('week', $this->sentQuery()['period']);
    }

    #[Test]
    public function it_sends_the_case_twitch_expects_for_status_and_reason_values(): void
    {
        $this->makeService(new Response(
            200,
            [],
            '{"data":[],"pagination":{}}',
        ))->getUnbanRequests(
            '111',
            '111',
            'PENDING',
        );
        $unban = $this->sentQuery();

        $this->makeService(new Response(204))->blockUser(
            '333',
            'SPAM',
            'Chat',
        );
        $block = $this->sentBody();

        $this->makeService(new Response(204))->updateUserChatColor('111', 'Blue');
        $color = $this->sentQuery();

        self::assertSame('pending', $unban['status']);
        self::assertSame('spam', $block['reason']);
        self::assertSame('chat', $block['source_context']);
        self::assertSame('blue', $color['color']);
    }

    #[Test]
    public function it_sends_the_documented_parameters_that_were_missing(): void
    {
        $page = '{"data":[],"pagination":{}}';

        $this->makeService(new Response(
            200,
            [],
            $page,
        ))->getStreams(null, null, null, 5, null, [
            'alpha',
            'beta',
        ], 'LIVE', 'cursor-before');
        $streams = $this->sentQuery();

        $this->makeService(new Response(
            200,
            [],
            $page,
        ))->getVideos(
            '12826',
            null,
            null,
            'all',
            5,
            null,
            null,
            null,
            null,
            'cursor-before',
        );
        $videos = $this->sentQuery();

        $this->makeService(new Response(
            200,
            [],
            '{"data":[]}',
        ))->getGames(null, null, [
            '1',
            '2',
        ]);
        $games = $this->sentQuery();

        $this->makeService(new Response(
            200,
            [],
            $page,
        ))->getSubscriptions(
            '111',
            null,
            20,
            null,
            'cursor-before',
        );
        $subscriptions = $this->sentQuery();

        $this->makeService(new Response(
            200,
            [],
            '{"data":{"segments":[],"broadcaster_id":"1","broadcaster_name":"B","broadcaster_login":"b"}}',
        ))->getSchedule(
            '111',
            null,
            20,
            null,
            '2026-11-25T10:00:00Z',
        );
        $schedule = $this->sentQuery();

        self::assertSame([
            'alpha',
            'beta',
        ], $streams['user_login']);
        self::assertSame('live', $streams['type']);
        self::assertSame('cursor-before', $streams['before']);
        self::assertSame('cursor-before', $videos['before']);
        self::assertSame([
            '1',
            '2',
        ], $games['igdb_id']);
        self::assertSame('cursor-before', $subscriptions['before']);
        self::assertSame('2026-11-25T10:00:00Z', $schedule['start_time']);
    }

    #[Test]
    public function it_sends_the_redemption_sort_and_the_guest_reinvite_flag(): void
    {
        $this->makeService(new Response(
            200,
            [],
            '{"data":[],"pagination":{}}',
        ))->getRedemptions(
            '111',
            'reward-1',
            'unfulfilled',
            null,
            20,
            null,
            'newest',
        );
        $redemptions = $this->sentQuery();

        $this->makeService(new Response(204))->deleteGuestStarSlot(
            '111',
            '111',
            'session-1',
            'guest-1',
            '2',
            true,
        );
        $slot = $this->sentQuery();

        // Twitch is case-sensitive on both.
        self::assertSame('UNFULFILLED', $redemptions['status']);
        self::assertSame('NEWEST', $redemptions['sort']);
        self::assertSame('true', $slot['should_reinvite_guest']);
    }

    #[Test]
    public function it_sends_the_video_language_period_and_sort(): void
    {
        $this->makeService(new Response(
            200,
            [],
            '{"data":[]}',
        ))->getVideos(
            '12826',
            null,
            null,
            'all',
            5,
            null,
            'en',
            'week',
            'views',
        );

        $query = $this->sentQuery();

        self::assertSame('en', $query['language']);
        self::assertSame('week', $query['period']);
        self::assertSame('views', $query['sort']);
    }

    #[Test]
    public function it_subscribes_through_a_conduit(): void
    {
        $this->makeService($this->subscriptionResponse('channel.update', '2'))
            ->createEventSubConduitSubscription('channel.update', [
                'broadcaster_user_id' => '1',
            ], 'conduit-1');

        $body = $this->sentBody();

        self::assertSame([
            'method'     => 'conduit',
            'conduit_id' => 'conduit-1',
        ], $body['transport']);
        self::assertSame('2', $body['version']);
    }

    #[Test]
    public function it_subscribes_with_the_latest_version_of_the_type_by_default(): void
    {
        // Twitch answers 410 to channel.follow version 1.
        $this->makeService($this->subscriptionResponse('channel.follow', '2'))
            ->createEventSubSubscription('channel.follow', [
                'broadcaster_user_id' => '1',
                'moderator_user_id'   => '1',
            ], 'https://example.com/hook', 'a-secret-of-ten-chars');

        self::assertSame('2', $this->sentBody()['version']);
        self::assertArrayNotHasKey('is_batching_enabled', $this->sentBody());
    }

    #[Test]
    public function it_throws_when_twitch_refuses_some_conduit_shards(): void
    {
        // Twitch answers 202 with the refused shards in `errors`: they used to be lost silently.
        $service = $this->makeService(new Response(202, [], json_encode([
            'data'   => [
                [
                    'id'        => '0',
                    'status'    => 'enabled',
                    'transport' => [
                        'method'   => 'webhook',
                        'callback' => 'https://example.com/hook',
                    ],
                ],
            ],
            'errors' => [
                [
                    'id'      => '5',
                    'message' => 'The shard id is out of range.',
                    'code'    => 'invalid_parameter',
                ],
            ],
        ], JSON_THROW_ON_ERROR)));

        try {
            $service->updateConduitShards('conduit-1', [
                new UpdateConduitShardRequest('0', [
                    'method'   => 'webhook',
                    'callback' => 'https://example.com/hook',
                    'secret'   => 'a-secret-of-ten',
                ]),
                new UpdateConduitShardRequest('5', [
                    'method'   => 'webhook',
                    'callback' => 'https://example.com/hook',
                    'secret'   => 'a-secret-of-ten',
                ]),
            ]);
            self::fail('A ConduitShardsUpdateFailed exception was expected.');
        }
        catch (ConduitShardsUpdateFailed $conduitShardsUpdateFailed) {
            self::assertCount(1, $conduitShardsUpdateFailed->errors);
            self::assertSame('5', $conduitShardsUpdateFailed->errors[0]['id']);
            self::assertCount(1, $conduitShardsUpdateFailed->shards);
            self::assertStringContainsString('shard 5', $conduitShardsUpdateFailed->getMessage());
        }
    }

    #[Test]
    public function it_updates_the_guest_star_settings_with_patch_and_without_a_moderator(): void
    {
        // The reference documents PATCH with broadcaster_id only; the package sent PUT with a moderator_id.
        $this->makeService(new Response(204))->updateChannelGuestStarSettings(
            '111',
            '222',
            new UpdateGuestStarSettingsRequest(
                slotCount: 4,
                groupLayout: 'TILED',
                broadcasterAudioSetting: 'EVERYONE',
                regenerateBrowserSources: true,
            ),
        );

        $request = $this->sentRequest();
        $body    = $this->sentBody();

        self::assertSame('PATCH', $request->getMethod());
        self::assertSame('/helix/guest_star/channel_settings', $request->getUri()->getPath());
        self::assertSame('111', $body['broadcaster_id']);
        self::assertSame(4, $body['slot_count']);
        self::assertTrue($body['regenerate_browser_sources']);
        self::assertArrayNotHasKey('moderator_id', $body);
        self::assertArrayNotHasKey('broadcaster_audio_setting', $body);
    }

    #[Test]
    public function it_uses_the_documented_names_for_the_extension_pubsub_message(): void
    {
        // The reference names the field `target` (not `targets`) and has no extension_id (the JWT carries it).
        $this->makeService(new Response(204))->sendExtensionPubSubMessage('111', 'ext-1', 'hello', [
            'broadcast',
        ]);
        $channel = $this->sentBody();

        $this->makeService(new Response(204))->sendExtensionPubSubMessage('111', 'ext-1', 'hello', [
            'global',
        ], true);
        $global = $this->sentBody();

        self::assertSame([
            'broadcast',
        ], $channel['target']);
        self::assertSame('111', $channel['broadcaster_id']);
        self::assertArrayNotHasKey('targets', $channel);
        self::assertArrayNotHasKey('extension_id', $channel);
        self::assertTrue($global['is_global_broadcast']);
        self::assertArrayNotHasKey('broadcaster_id', $global);
    }

    private function makeService(Response ...$responses): TwitchApiService
    {
        $this->requests = [];
        $handlerStack   = HandlerStack::create(new MockHandler($responses));
        $handlerStack->push(Middleware::mapRequest(function (RequestInterface $request): RequestInterface {
            $this->requests[] = $request;

            return $request;
        }));

        $twitchApiService = new TwitchApiService('test-client-id', 'test-client-secret');
        $twitchApiService->setAccessToken('test-token');

        new ReflectionProperty(TwitchApiService::class, 'client')->setValue(
            $twitchApiService,
            new Client([
                'base_uri' => 'https://api.twitch.tv/helix/',
                'handler'  => $handlerStack,
            ]),
        );

        return $twitchApiService;
    }

    /**
     * @return array<string, mixed>
     */
    private function sentBody(): array
    {
        $body = json_decode(
            (string) $this->sentRequest()->getBody(),
            true,
            512,
            JSON_THROW_ON_ERROR,
        );
        self::assertIsArray($body);

        /** @var array<string, mixed> $body */
        return $body;
    }

    /**
     * @return array<int|string, array<mixed>|string>
     */
    private function sentQuery(): array
    {
        parse_str($this->sentRequest()->getUri()->getQuery(), $query);

        return $query;
    }

    private function sentRequest(): RequestInterface
    {
        $request = $this->requests[0] ?? null;
        self::assertNotNull($request);

        return $request;
    }

    private function subscriptionResponse(string $type, string $version): Response
    {
        return new Response(202, [], json_encode([
            'data' => [
                [
                    'id'         => 'sub-1',
                    'status'     => 'enabled',
                    'type'       => $type,
                    'version'    => $version,
                    'condition'  => [
                        'broadcaster_user_id' => '1',
                    ],
                    'created_at' => '2026-11-20T10:00:00.123Z',
                    'transport'  => [
                        'method'   => 'webhook',
                        'callback' => 'https://example.com/hook',
                    ],
                    'cost'       => 1,
                ],
            ],
        ], JSON_THROW_ON_ERROR));
    }
}
