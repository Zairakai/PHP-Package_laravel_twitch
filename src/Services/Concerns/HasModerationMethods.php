<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Spatie\LaravelData\DataCollection;
use Zairakai\LaravelTwitch\Dto\Moderation\AutoModCheckResult;
use Zairakai\LaravelTwitch\Dto\Moderation\AutoModSettings;
use Zairakai\LaravelTwitch\Dto\Moderation\BannedUser;
use Zairakai\LaravelTwitch\Dto\Moderation\BanResult;
use Zairakai\LaravelTwitch\Dto\Moderation\BlockedTerm;
use Zairakai\LaravelTwitch\Dto\Moderation\ModeratedChannel;
use Zairakai\LaravelTwitch\Dto\Moderation\Moderator;
use Zairakai\LaravelTwitch\Dto\Moderation\Requests\AutoModMessageRequest;
use Zairakai\LaravelTwitch\Dto\Moderation\Requests\UpdateAutoModSettingsRequest;
use Zairakai\LaravelTwitch\Dto\Moderation\ShieldMode;
use Zairakai\LaravelTwitch\Dto\Moderation\SuspiciousUser;
use Zairakai\LaravelTwitch\Dto\Moderation\UnbanRequest;
use Zairakai\LaravelTwitch\Dto\Moderation\Vip;
use Zairakai\LaravelTwitch\Dto\Moderation\WarnedUser;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;

/**
 * Twitch Moderation API methods.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#ban-user
 */
trait HasModerationMethods
{
    /**
     * Add a blocked term to the broadcaster's channel.
     *
     * Requires: moderator:manage:blocked_terms
     */
    public function addBlockedTerm(
        string $broadcasterId,
        string $moderatorId,
        string $text,
    ): BlockedTerm {
        $raw = $this->makeRequest('POST', '/moderation/blocked_terms', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'text'           => $text,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return BlockedTerm::from($items[0]);
    }

    /**
     * Add a moderator to a broadcaster's channel.
     *
     * Requires: channel:manage:moderators
     */
    public function addModerator(string $broadcasterId, string $userId): void
    {
        $this->makeRequest('POST', '/moderation/moderators', [
            'broadcaster_id' => $broadcasterId,
            'user_id'        => $userId,
        ]);
    }

    /**
     * Mark a user as suspicious or restricted in the broadcaster's channel.
     *
     * Requires: moderator:manage:suspicious_users
     *
     * @param string $status suspicious or restricted
     */
    public function addSuspiciousUser(
        string $broadcasterId,
        string $moderatorId,
        string $targetUserId,
        string $status,
    ): SuspiciousUser {
        $raw = $this->makeRequest('POST', '/moderation/suspicious_users', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'user_id'        => $targetUserId,
            'status'         => $status,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return SuspiciousUser::from($items[0]);
    }

    /**
     * Add a VIP to the broadcaster's channel.
     *
     * Requires: channel:manage:vips
     */
    public function addVip(string $broadcasterId, string $userId): void
    {
        $this->makeRequest('POST', '/channels/vips', [
            'broadcaster_id' => $broadcasterId,
            'user_id'        => $userId,
        ]);
    }

    /**
     * Ban a user from a broadcaster's chat permanently.
     *
     * Requires: moderator:manage:banned_users
     */
    public function banUser(
        string $broadcasterId,
        string $moderatorId,
        string $userId,
        ?string $reason = null,
    ): BanResult {
        $data = ['user_id' => $userId];

        if (null !== $reason) {
            $data['reason'] = $reason;
        }

        $raw = $this->makeRequest('POST', '/moderation/bans', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'data'           => $data,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return BanResult::from($items[0]);
    }

    /**
     * Check whether AutoMod would flag the specified messages.
     *
     * Requires: moderation:read
     *
     * @param list<AutoModMessageRequest> $messages Messages to check
     *
     * @return DataCollection<int, AutoModCheckResult>
     */
    public function checkAutoModStatus(string $broadcasterId, array $messages): DataCollection
    {
        $raw = $this->makeRequest('POST', '/moderation/enforcements/status', [
            'broadcaster_id' => $broadcasterId,
            'data'           => array_map(
                static fn (AutoModMessageRequest $autoModMessageRequest): array => $autoModMessageRequest->toArray(),
                $messages,
            ),
        ]);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, AutoModCheckResult> $dataCollection */
        $dataCollection = AutoModCheckResult::collect($items, DataCollection::class);

        return $dataCollection;
    }

    /**
     * Get the broadcaster's AutoMod settings.
     *
     * Requires: moderator:read:automod_settings
     */
    public function getAutoModSettings(string $broadcasterId, string $moderatorId): AutoModSettings
    {
        $raw = $this->makeRequest('GET', '/moderation/automod/settings', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return AutoModSettings::from($items[0]);
    }

    /**
     * Get the list of banned or timed out users for a broadcaster.
     *
     * Requires: moderation:read
     *
     * @return PaginatedResult<BannedUser>
     */
    public function getBannedUsers(
        string $broadcasterId,
        ?string $userId = null,
        int $first = 20,
        ?string $after = null,
    ): PaginatedResult {
        $params = [
            'broadcaster_id' => $broadcasterId,
            'first'          => $first,
        ];

        if (null !== $userId) {
            $params['user_id'] = $userId;
        }

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/moderation/banned', $params);

        return PaginatedResult::fromRaw($raw, BannedUser::class);
    }

    /**
     * Get the broadcaster's blocked terms.
     *
     * Requires: moderator:read:blocked_terms
     *
     * @return PaginatedResult<BlockedTerm>
     */
    public function getBlockedTerms(
        string $broadcasterId,
        string $moderatorId,
        int $first = 20,
        ?string $after = null,
    ): PaginatedResult {
        $params = [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'first'          => $first,
        ];

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/moderation/blocked_terms', $params);

        return PaginatedResult::fromRaw($raw, BlockedTerm::class);
    }

    /**
     * Get the list of channels where the user has moderator privileges.
     *
     * Requires: user:read:moderated_channels
     *
     * @return PaginatedResult<ModeratedChannel>
     */
    public function getModeratedChannels(
        string $userId,
        ?string $after = null,
        int $first = 20,
    ): PaginatedResult {
        $params = [
            'user_id' => $userId,
            'first'   => $first,
        ];

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/moderation/channels', $params);

        return PaginatedResult::fromRaw($raw, ModeratedChannel::class);
    }

    /**
     * Get the list of moderators for a broadcaster's channel.
     *
     * Requires: moderation:read
     *
     * @return PaginatedResult<Moderator>
     */
    public function getModerators(
        string $broadcasterId,
        ?string $userId = null,
        int $first = 20,
        ?string $after = null,
    ): PaginatedResult {
        $params = [
            'broadcaster_id' => $broadcasterId,
            'first'          => $first,
        ];

        if (null !== $userId) {
            $params['user_id'] = $userId;
        }

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/moderation/moderators', $params);

        return PaginatedResult::fromRaw($raw, Moderator::class);
    }

    /**
     * Get the broadcaster's Shield Mode status.
     *
     * Requires: moderator:read:shield_mode
     */
    public function getShieldMode(string $broadcasterId, string $moderatorId): ShieldMode
    {
        $raw = $this->makeRequest('GET', '/moderation/shield_mode', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return ShieldMode::from($items[0]);
    }

    /**
     * Get a list of unban requests for a broadcaster's channel.
     *
     * Requires: moderator:read:unban_requests or moderator:manage:unban_requests
     *
     * @param string $status pending, approved, denied, acknowledged, or cancelled
     *
     * @return PaginatedResult<UnbanRequest>
     */
    public function getUnbanRequests(
        string $broadcasterId,
        string $moderatorId,
        string $status,
        ?string $userId = null,
        ?string $after = null,
        int $first = 20,
    ): PaginatedResult {
        $params = [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'status'         => $status,
            'first'          => $first,
        ];

        if (null !== $userId) {
            $params['user_id'] = $userId;
        }

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/moderation/unban_requests', $params);

        return PaginatedResult::fromRaw($raw, UnbanRequest::class);
    }

    /**
     * Get the list of VIPs for a broadcaster's channel.
     *
     * Requires: channel:read:vips
     *
     * @return PaginatedResult<Vip>
     */
    public function getVips(
        string $broadcasterId,
        ?string $userId = null,
        int $first = 20,
        ?string $after = null,
    ): PaginatedResult {
        $params = [
            'broadcaster_id' => $broadcasterId,
            'first'          => $first,
        ];

        if (null !== $userId) {
            $params['user_id'] = $userId;
        }

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/channels/vips', $params);

        return PaginatedResult::fromRaw($raw, Vip::class);
    }

    /**
     * Allow or deny a message that AutoMod flagged.
     *
     * Requires: moderator:manage:chat_messages
     *
     * @param string $action ALLOW or DENY
     */
    public function manageHeldMessage(
        string $userId,
        string $msgId,
        string $action,
    ): void {
        $this->makeRequest('POST', '/moderation/automod/message', [
            'user_id' => $userId,
            'msg_id'  => $msgId,
            'action'  => $action,
        ]);
    }

    /**
     * Remove a blocked term from the broadcaster's channel.
     *
     * Requires: moderator:manage:blocked_terms
     */
    public function removeBlockedTerm(
        string $broadcasterId,
        string $moderatorId,
        string $termId,
    ): void {
        $this->makeRequest('DELETE', '/moderation/blocked_terms', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'id'             => $termId,
        ]);
    }

    /**
     * Remove a moderator from a broadcaster's channel.
     *
     * Requires: channel:manage:moderators
     */
    public function removeModerator(string $broadcasterId, string $userId): void
    {
        $this->makeRequest('DELETE', '/moderation/moderators', [
            'broadcaster_id' => $broadcasterId,
            'user_id'        => $userId,
        ]);
    }

    /**
     * Remove the suspicious or restricted status from a user.
     *
     * Requires: moderator:manage:suspicious_users
     */
    public function removeSuspiciousUser(
        string $broadcasterId,
        string $moderatorId,
        string $targetUserId,
    ): void {
        $this->makeRequest('DELETE', '/moderation/suspicious_users', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'user_id'        => $targetUserId,
        ]);
    }

    /**
     * Remove a VIP from the broadcaster's channel.
     *
     * Requires: channel:manage:vips
     */
    public function removeVip(string $broadcasterId, string $userId): void
    {
        $this->makeRequest('DELETE', '/channels/vips', [
            'broadcaster_id' => $broadcasterId,
            'user_id'        => $userId,
        ]);
    }

    /**
     * Resolve an unban request (approve or deny).
     *
     * Requires: moderator:manage:unban_requests
     *
     * @param string      $status     approved or denied
     * @param string|null $resolution Optional resolution message (max 500 chars)
     */
    public function resolveUnbanRequest(
        string $broadcasterId,
        string $moderatorId,
        string $unbanRequestId,
        string $status,
        ?string $resolution = null,
    ): UnbanRequest {
        $params = [
            'broadcaster_id'   => $broadcasterId,
            'moderator_id'     => $moderatorId,
            'unban_request_id' => $unbanRequestId,
            'status'           => $status,
        ];

        if (null !== $resolution) {
            $params['resolution_text'] = $resolution;
        }

        $raw = $this->makeRequest('PATCH', '/moderation/unban_requests', $params);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return UnbanRequest::from($items[0]);
    }

    /**
     * Activate or deactivate the broadcaster's Shield Mode.
     *
     * Requires: moderator:manage:shield_mode
     */
    public function setShieldMode(
        string $broadcasterId,
        string $moderatorId,
        bool $isActive,
    ): ShieldMode {
        $raw = $this->makeRequest('PUT', '/moderation/shield_mode', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'is_active'      => $isActive,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return ShieldMode::from($items[0]);
    }

    /**
     * Timeout a user in a broadcaster's chat for a given duration.
     *
     * Requires: moderator:manage:banned_users
     *
     * @param int $duration Duration in seconds (max 1,209,600 = 2 weeks)
     */
    public function timeoutUser(
        string $broadcasterId,
        string $moderatorId,
        string $userId,
        int $duration,
        ?string $reason = null,
    ): BanResult {
        $data = [
            'user_id'  => $userId,
            'duration' => $duration,
        ];

        if (null !== $reason) {
            $data['reason'] = $reason;
        }

        $raw = $this->makeRequest('POST', '/moderation/bans', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'data'           => $data,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return BanResult::from($items[0]);
    }

    /**
     * Remove the ban or timeout that was placed on a user.
     *
     * Requires: moderator:manage:banned_users
     */
    public function unbanUser(string $broadcasterId, string $moderatorId, string $userId): void
    {
        $this->makeRequest('DELETE', '/moderation/bans', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'user_id'        => $userId,
        ]);
    }

    /**
     * Update the broadcaster's AutoMod settings.
     *
     * Requires: moderator:manage:automod_settings
     */
    public function updateAutoModSettings(
        string $broadcasterId,
        string $moderatorId,
        UpdateAutoModSettingsRequest $updateAutoModSettingsRequest,
    ): AutoModSettings {
        /** @var array<string, mixed> $requestData */
        $requestData = array_filter(
            $updateAutoModSettingsRequest->toArray(),
            static fn (mixed $v): bool => null !== $v,
        );

        $raw = $this->makeRequest('PUT', '/moderation/automod/settings', array_merge([
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
        ], $requestData));

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return AutoModSettings::from($items[0]);
    }

    /**
     * Warn a user in the broadcaster's chat.
     *
     * Requires: moderator:manage:warnings
     */
    public function warnUser(
        string $broadcasterId,
        string $moderatorId,
        string $userId,
        ?string $reason = null,
    ): WarnedUser {
        $data = ['user_id' => $userId];

        if (null !== $reason) {
            $data['reason'] = $reason;
        }

        $raw = $this->makeRequest('POST', '/moderation/warnings', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'data'           => $data,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return WarnedUser::from($items[0]);
    }
}
