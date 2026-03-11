<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Tests\Unit\Services\Concerns;

use PHPUnit\Framework\Attributes\Test;
use Zairakai\LaravelTwitch\Dto\Moderation\AutoModSettings;
use Zairakai\LaravelTwitch\Dto\Moderation\BannedUser;
use Zairakai\LaravelTwitch\Dto\Moderation\Requests\UpdateAutoModSettingsRequest;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;
use Zairakai\LaravelTwitch\Services\TwitchApiService;
use Zairakai\LaravelTwitch\Tests\TestCase;

final class HasModerationMethodsTest extends TestCase
{
    // ── getAutoModSettings ────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_automod_settings_endpoint(): void
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

                return [
                    'data' => [
                        [
                            'broadcaster_id' => '1',
                            'moderator_id'   => '2',
                        ],
                    ],
                ];
            }
        };

        $service->getAutoModSettings('1', '2');

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/moderation/automod/settings', $capturedParams['endpoint']);
    }

    // ── getBannedUsers ────────────────────────────────────────────────────────

    #[Test]
    public function it_calls_the_moderation_banned_endpoint(): void
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

                return ['data' => [], 'pagination' => ['cursor' => '']];
            }
        };

        $service->getBannedUsers('1');

        $this->assertSame('GET', $capturedParams['method']);
        $this->assertSame('/moderation/banned', $capturedParams['endpoint']);
    }

    #[Test]
    public function it_exercises_moderation_wrappers_for_actions_and_paginated_queries(): void
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

                return match ($endpoint) {
                    '/moderation/blocked_terms' => 'POST' === $method
                        ? ['data' => [[
                            'id'             => 'term-1',
                            'broadcaster_id' => 'b-1',
                            'moderator_id'   => 'm-1',
                            'text'           => 'blocked',
                            'created_at'     => '2024-01-01T00:00:00Z',
                            'updated_at'     => '2024-01-01T00:00:00Z',
                        ]]]
                        : ['data' => [], 'pagination' => []],
                    '/moderation/suspicious_users' => 'POST' === $method
                        ? ['data' => [[
                            'broadcaster_id'   => 'b-1',
                            'moderator_id'     => 'm-1',
                            'user_id'          => 'u-1',
                            'user_login'       => 'sus',
                            'user_name'        => 'Sus',
                            'low_trust_status' => 'restricted',
                        ]]]
                        : ['data' => []],
                    '/moderation/bans' => 'DELETE' === $method
                        ? ['data' => []]
                        : ['data' => [[
                            'broadcaster_id' => 'b-1',
                            'moderator_id'   => 'm-1',
                            'user_id'        => 'u-1',
                            'created_at'     => '2024-01-01T00:00:00Z',
                        ]]],
                    '/moderation/automod/settings' => ['data' => [[
                        'broadcaster_id'             => 'b-1',
                        'moderator_id'               => 'm-1',
                        'overall_level'              => null,
                        'disability'                 => 0,
                        'aggression'                 => 0,
                        'sexuality_sex_or_gender'    => 0,
                        'misogyny'                   => 0,
                        'bullying'                   => 0,
                        'swearing'                   => 0,
                        'race_ethnicity_or_religion' => 0,
                        'sex_based_terms'            => 0,
                    ]]],
                    '/moderation/shield_mode' => ['data' => [[
                        'is_active'       => true,
                        'moderator_id'    => 'm-1',
                        'moderator_login' => 'mod',
                        'moderator_name'  => 'Mod',
                    ]]],
                    '/moderation/unban_requests' => 'PATCH' === $method
                        ? ['data' => [[
                            'id'                => 'req-1',
                            'broadcaster_id'    => 'b-1',
                            'broadcaster_login' => 'b',
                            'broadcaster_name'  => 'B',
                            'user_id'           => 'u-1',
                            'user_login'        => 'u',
                            'user_name'         => 'U',
                            'text'              => 'please',
                            'status'            => 'approved',
                        ]]]
                        : ['data' => [], 'pagination' => []],
                    '/moderation/warnings' => ['data' => [[
                        'broadcaster_id' => 'b-1',
                        'user_id'        => 'u-1',
                        'moderator_id'   => 'm-1',
                        'reason'         => 'warning',
                    ]]],
                    default => ['data' => [], 'pagination' => []],
                };
            }
        };

        $service->addBlockedTerm('b-1', 'm-1', 'blocked');
        $service->addModerator('b-1', 'u-1');
        $service->addSuspiciousUser('b-1', 'm-1', 'u-1', 'restricted');
        $service->addVip('b-1', 'u-1');
        $service->banUser('b-1', 'm-1', 'u-1', 'spam');
        $service->checkAutoModStatus('b-1', []);
        $service->getAutoModSettings('b-1', 'm-1');
        $service->getBannedUsers('b-1', 'u-1', 5, 'cur-1');
        $service->getBlockedTerms('b-1', 'm-1', 5, 'cur-2');
        $service->getModeratedChannels('u-1', 'cur-3', 5);
        $service->getModerators('b-1', 'u-1', 5, 'cur-4');
        $service->getShieldMode('b-1', 'm-1');
        $service->getUnbanRequests('b-1', 'm-1', 'pending', 'u-1', 'cur-5', 5);
        $service->getVips('b-1', 'u-1', 5, 'cur-6');
        $service->manageHeldMessage('u-1', 'msg-1', 'ALLOW');
        $service->removeBlockedTerm('b-1', 'm-1', 'term-1');
        $service->removeModerator('b-1', 'u-1');
        $service->removeSuspiciousUser('b-1', 'm-1', 'u-1');
        $service->removeVip('b-1', 'u-1');
        $service->resolveUnbanRequest('b-1', 'm-1', 'req-1', 'approved', 'ok');
        $service->setShieldMode('b-1', 'm-1', true);
        $service->timeoutUser('b-1', 'm-1', 'u-1', 60, 'cool down');
        $service->unbanUser('b-1', 'm-1', 'u-1');
        $service->updateAutoModSettings('b-1', 'm-1', new UpdateAutoModSettingsRequest(overallLevel: 2));
        $service->warnUser('b-1', 'm-1', 'u-1', 'warning');

        $this->assertGreaterThanOrEqual(25, count($service->calls));
        $this->assertSame('/moderation/blocked_terms', $service->calls[0]['endpoint']);
        $this->assertSame('/moderation/moderators', $service->calls[1]['endpoint']);
        $this->assertSame('/moderation/warnings', $service->calls[array_key_last($service->calls)]['endpoint']);
    }

    #[Test]
    public function it_returns_a_paginated_result_of_banned_users(): void
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
                            'user_id'         => '1',
                            'user_login'      => 'test',
                            'user_name'       => 'Test',
                            'reason'          => '',
                            'moderator_id'    => '2',
                            'moderator_login' => 'mod',
                            'moderator_name'  => 'Mod',
                            'created_at'      => '2024-01-01T00:00:00Z',
                        ],
                    ],
                    'pagination' => ['cursor' => 'abc123'],
                ];
            }
        };

        $paginatedResult = $service->getBannedUsers('1');

        $this->assertInstanceOf(PaginatedResult::class, $paginatedResult);
        $this->assertCount(1, $paginatedResult->items);
        $this->assertInstanceOf(BannedUser::class, $paginatedResult->items[0]);
        $this->assertSame('1', $paginatedResult->items[0]->userId);
    }

    #[Test]
    public function it_returns_an_auto_mod_settings_dto(): void
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
                            'broadcaster_id'             => '1',
                            'moderator_id'               => '2',
                            'overall_level'              => null,
                            'disability'                 => 0,
                            'aggression'                 => 0,
                            'sexuality_sex_or_gender'    => 0,
                            'misogyny'                   => 0,
                            'bullying'                   => 0,
                            'swearing'                   => 0,
                            'race_ethnicity_or_religion' => 0,
                            'sex_based_terms'            => 0,
                        ],
                    ],
                ];
            }
        };

        $autoModSettings = $service->getAutoModSettings('1', '2');

        $this->assertInstanceOf(AutoModSettings::class, $autoModSettings);
        $this->assertSame('1', $autoModSettings->broadcasterId);
        $this->assertSame('2', $autoModSettings->moderatorId);
        $this->assertNull($autoModSettings->overallLevel);
    }
}
