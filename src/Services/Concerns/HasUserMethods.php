<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Spatie\LaravelData\DataCollection;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;
use Zairakai\LaravelTwitch\Dto\Users\BlockedUser;
use Zairakai\LaravelTwitch\Dto\Users\FollowedChannel;
use Zairakai\LaravelTwitch\Dto\Users\Follower;
use Zairakai\LaravelTwitch\Dto\Users\Subscription;
use Zairakai\LaravelTwitch\Dto\Users\SubscriptionCheck;
use Zairakai\LaravelTwitch\Dto\Users\User;
use Zairakai\LaravelTwitch\Dto\Users\UserAuthorization;

/**
 * Twitch User API methods.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-users
 */
trait HasUserMethods
{
    /**
     * Block a specific user from interacting with the authenticated user.
     *
     * Requires: user:manage:blocked_users
     *
     * @param string|null $reason harassment, spam, or other
     */
    public function blockUser(string $targetUserId, ?string $reason = null): void
    {
        $params = ['target_user_id' => $targetUserId];

        if (null !== $reason) {
            $params['reason'] = $reason;
        }

        $this->makeRequest('PUT', '/users/blocks', $params);
    }

    /**
     * Check whether a user subscribes to a broadcaster's channel.
     *
     * Requires: channel:read:subscriptions
     */
    public function checkUserSubscription(string $broadcasterId, string $userId): SubscriptionCheck
    {
        $raw = $this->makeRequest('GET', '/subscriptions/user', [
            'broadcaster_id' => $broadcasterId,
            'user_id'        => $userId,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return SubscriptionCheck::from($items[0]);
    }

    /**
     * Get the currently authenticated user.
     *
     * Call this after setAccessToken() to retrieve the user whose token was provided.
     * Requires: no scope (user:read:email adds email field)
     */
    public function getAuthenticatedUser(): ?User
    {
        $raw = $this->makeRequest('GET', '/users', []);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        return isset($items[0]) ? User::from($items[0]) : null;
    }

    /**
     * Get the authorization scopes that the specified user(s) have granted
     * this application.
     *
     * Requires: app access token
     *
     * Confirmed verbatim against Twitch's own docs (2026-08-27) - GET
     * /helix/authorization/users. Real bug fixed here: this used to call the
     * reversed, non-existent /users/authorization (which would 404 on every
     * call, broken since first written) with no user_id param and returned
     * a fabricated DTO (client_id/description/created_at/updated_at) that
     * matched no real Twitch response shape.
     *
     * @param string|array<string> $userIds One or more user IDs to check (max 10)
     *
     * @return DataCollection<int, UserAuthorization>
     */
    public function getAuthorizationByUser(string|array $userIds): DataCollection
    {
        $raw = $this->makeRequest('GET', '/authorization/users', [
            'user_id' => $userIds,
        ]);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, UserAuthorization> $dataCollection */
        $dataCollection = UserAuthorization::collect($items, DataCollection::class);

        return $dataCollection;
    }

    /**
     * Get the list of users who follow the specified broadcaster.
     *
     * Requires: moderator:read:followers
     *
     * @return PaginatedResult<Follower>
     */
    public function getChannelFollowers(
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

        $raw = $this->makeRequest('GET', '/channels/followers', $params);

        return PaginatedResult::fromRaw($raw, Follower::class);
    }

    /**
     * Get the channels that the authenticated user follows.
     *
     * Requires: user:read:follows
     *
     * @return PaginatedResult<FollowedChannel>
     */
    public function getFollowedChannels(
        string $userId,
        ?string $broadcasterId = null,
        int $first = 20,
        ?string $after = null,
    ): PaginatedResult {
        $params = [
            'user_id' => $userId,
            'first'   => $first,
        ];

        if (null !== $broadcasterId) {
            $params['broadcaster_id'] = $broadcasterId;
        }

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/channels/followed', $params);

        return PaginatedResult::fromRaw($raw, FollowedChannel::class);
    }

    /**
     * Get the list of channels that the specified broadcaster's users subscribe to.
     *
     * Requires: channel:read:subscriptions
     *
     * @return PaginatedResult<Subscription>
     */
    public function getSubscriptions(
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

        $raw = $this->makeRequest('GET', '/subscriptions', $params);

        return PaginatedResult::fromRaw($raw, Subscription::class);
    }

    /**
     * Get the active extensions used by a specified user.
     *
     * Requires: user:read:broadcast (for own active extensions, optional)
     *
     * Note: the response has a complex nested structure (panel/overlay/component
     * maps indexed by slot number). Returned as raw array until a dedicated DTO
     * is available in a future release.
     *
     * Confirmed verbatim against Twitch's own docs (2026-08-27) - GET
     * /helix/users/extensions. Real bug fixed here: this used to call the
     * non-existent /users/extensions/active, which would 404 on every call,
     * broken since first written - it also had swapped URLs with
     * getUserExtensions() below.
     *
     * @return array<string, mixed>
     */
    public function getUserActiveExtensions(?string $userId = null): array
    {
        $params = [];

        if (null !== $userId) {
            $params['user_id'] = $userId;
        }

        return $this->makeRequest('GET', '/users/extensions', $params);
    }

    /**
     * Get the list of users that the authenticated user has blocked.
     *
     * Requires: user:read:blocked_users
     *
     * @return PaginatedResult<BlockedUser>
     */
    public function getUserBlocks(string $broadcasterId, int $first = 20, ?string $after = null): PaginatedResult
    {
        $params = [
            'broadcaster_id' => $broadcasterId,
            'first'          => $first,
        ];

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/users/blocks', $params);

        return PaginatedResult::fromRaw($raw, BlockedUser::class);
    }

    /**
     * Get the list of all extensions (active and inactive) installed by the
     * authenticated broadcaster. Unlike getUserActiveExtensions(), this always
     * identifies the broadcaster from the access token - Twitch's API takes
     * no user_id parameter here.
     *
     * Requires: user:read:broadcast or user:edit:broadcast (to include
     * inactive extensions)
     *
     * Note: the response has a complex nested structure (panel/overlay/component
     * maps indexed by slot number). Returned as raw array until a dedicated DTO
     * is available in a future release.
     *
     * Confirmed verbatim against Twitch's own docs (2026-08-27) - GET
     * /helix/users/extensions/list, no query parameters. Real bug fixed here:
     * this used to call /users/extensions (no path suffix) with an
     * undocumented user_id param - that URL is actually
     * getUserActiveExtensions()'s endpoint, the two were swapped.
     *
     * @return array<string, mixed>
     */
    public function getUserExtensions(): array
    {
        return $this->makeRequest('GET', '/users/extensions/list', []);
    }

    /**
     * Get information about one or more users by ID or login.
     *
     * Requires: no scope (user:read:email adds email field)
     *
     * @param string|array<string>|null $ids    User ID(s)
     * @param string|array<string>|null $logins User login(s)
     *
     * @return DataCollection<int, User>
     */
    public function getUsers(
        string|array|null $ids = null,
        string|array|null $logins = null,
    ): DataCollection {
        $params = [];

        if (null !== $ids) {
            $params['id'] = $ids;
        }

        if (null !== $logins) {
            $params['login'] = $logins;
        }

        $raw = $this->makeRequest('GET', '/users', $params);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, User> $dataCollection */
        $dataCollection = User::collect($items, DataCollection::class);

        return $dataCollection;
    }

    /**
     * Remove the block that the authenticated user has placed on a target user.
     *
     * Requires: user:manage:blocked_users
     */
    public function unblockUser(string $targetUserId): void
    {
        $this->makeRequest('DELETE', '/users/blocks', [
            'target_user_id' => $targetUserId,
        ]);
    }

    /**
     * Update the authenticated user's description.
     *
     * Requires: user:edit
     */
    public function updateUser(?string $description = null): User
    {
        $params = [];

        if (null !== $description) {
            $params['description'] = $description;
        }

        $raw = $this->makeRequest('PUT', '/users', $params);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return User::from($items[0]);
    }

    /**
     * Update the active extensions installed for a user.
     *
     * Requires: user:edit:broadcast
     *
     * Note: the request and response both use complex nested structures
     * (panel/overlay/component maps indexed by slot number). Returned as raw
     * array until dedicated DTOs are available in a future release.
     *
     * @param array<string, mixed> $data Extensions data with panel, overlay, component keys
     *
     * @return array<string, mixed>
     */
    public function updateUserExtensions(array $data): array
    {
        return $this->makeRequest('PUT', '/users/extensions', [
            'data' => $data,
        ]);
    }
}
