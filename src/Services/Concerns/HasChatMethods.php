<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use Spatie\LaravelData\DataCollection;
use Zairakai\LaravelTwitch\Dto\Chat\Badge;
use Zairakai\LaravelTwitch\Dto\Chat\ChatColor;
use Zairakai\LaravelTwitch\Dto\Chat\ChatSettings;
use Zairakai\LaravelTwitch\Dto\Chat\Chatter;
use Zairakai\LaravelTwitch\Dto\Chat\Emote;
use Zairakai\LaravelTwitch\Dto\Chat\PinnedChatMessage;
use Zairakai\LaravelTwitch\Dto\Chat\Requests\UpdateChatSettingsRequest;
use Zairakai\LaravelTwitch\Dto\Chat\SentMessage;
use Zairakai\LaravelTwitch\Dto\Chat\SharedChatSession;
use Zairakai\LaravelTwitch\Dto\PaginatedResult;

/**
 * Twitch Chat API methods.
 *
 * Requires user access token with appropriate chat scopes.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#send-chat-message
 */
trait HasChatMethods
{
    /**
     * Clear all messages in a broadcaster's chat.
     *
     * Shorthand for deleteMessage() without a message ID.
     * Requires: moderator:manage:chat_messages
     */
    public function clearChat(string $broadcasterId, string $moderatorId): void
    {
        $this->deleteMessage($broadcasterId, $moderatorId);
    }

    /**
     * Delete a specific chat message or clear the entire chat.
     *
     * Requires: moderator:manage:chat_messages
     *
     * @param string|null $messageId Specific message to delete; null clears all chat
     */
    public function deleteMessage(
        string $broadcasterId,
        string $moderatorId,
        ?string $messageId = null,
    ): void {
        $params = [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
        ];

        if (null !== $messageId) {
            $params['message_id'] = $messageId;
        }

        $this->makeRequest('DELETE', '/moderation/chat', $params);
    }

    /**
     * Get the broadcaster's custom chat badges.
     *
     * Requires: no scope (public endpoint)
     *
     * @return DataCollection<int, Badge>
     */
    public function getChannelBadges(string $broadcasterId): DataCollection
    {
        $raw = $this->makeRequest('GET', '/chat/badges', ['broadcaster_id' => $broadcasterId]);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, Badge> $dataCollection */
        $dataCollection = Badge::collect($items, DataCollection::class);

        return $dataCollection;
    }

    /**
     * Get all emotes for a broadcaster's channel.
     *
     * Requires: no scope (public endpoint)
     *
     * @return DataCollection<int, Emote>
     */
    public function getChannelEmotes(string $broadcasterId): DataCollection
    {
        $raw = $this->makeRequest('GET', '/chat/emotes', ['broadcaster_id' => $broadcasterId]);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, Emote> $dataCollection */
        $dataCollection = Emote::collect($items, DataCollection::class);

        return $dataCollection;
    }

    /**
     * Get current chat settings for a broadcaster's channel.
     *
     * Requires: moderator:read:chat_settings (or channel:manage:broadcast)
     */
    public function getChatSettings(string $broadcasterId, ?string $moderatorId = null): ChatSettings
    {
        $params = ['broadcaster_id' => $broadcasterId];

        if (null !== $moderatorId) {
            $params['moderator_id'] = $moderatorId;
        }

        $raw = $this->makeRequest('GET', '/chat/settings', $params);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return ChatSettings::from($items[0]);
    }

    /**
     * Get the list of users currently in the broadcaster's chat.
     *
     * Requires: moderator:read:chatters
     *
     * @return PaginatedResult<Chatter>
     */
    public function getChatters(
        string $broadcasterId,
        string $moderatorId,
        int $first = 100,
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

        $raw = $this->makeRequest('GET', '/chat/chatters', $params);

        return PaginatedResult::fromRaw($raw, Chatter::class);
    }

    /**
     * Get emote information for one or more specified emote sets.
     *
     * Requires: no scope
     *
     * Confirmed verbatim against Twitch's own docs (2026-08-27) - GET
     * /helix/chat/emotes/set. Real bug fixed here: this used to call the
     * non-existent /chat/emote_sets, which would 404 on every call, broken
     * since first written.
     *
     * @param string|array<string> $emoteSetIds One or more emote set IDs
     *
     * @return DataCollection<int, Emote>
     */
    public function getEmoteSets(string|array $emoteSetIds): DataCollection
    {
        $raw = $this->makeRequest('GET', '/chat/emotes/set', [
            'emote_set_id' => $emoteSetIds,
        ]);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, Emote> $dataCollection */
        $dataCollection = Emote::collect($items, DataCollection::class);

        return $dataCollection;
    }

    /**
     * Get Twitch's global chat badges.
     *
     * Requires: no scope
     *
     * @return DataCollection<int, Badge>
     */
    public function getGlobalBadges(): DataCollection
    {
        $raw = $this->makeRequest('GET', '/chat/badges/global', []);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, Badge> $dataCollection */
        $dataCollection = Badge::collect($items, DataCollection::class);

        return $dataCollection;
    }

    /**
     * Get all global Twitch emotes.
     *
     * Requires: no scope
     *
     * @return DataCollection<int, Emote>
     */
    public function getGlobalEmotes(): DataCollection
    {
        $raw = $this->makeRequest('GET', '/chat/emotes/global', []);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, Emote> $dataCollection */
        $dataCollection = Emote::collect($items, DataCollection::class);

        return $dataCollection;
    }

    /**
     * Get the broadcaster's currently mod-pinned chat message, if any.
     *
     * Requires: moderator:manage:chat_messages or moderator:read:chat_messages
     *
     * Confirmed verbatim against Twitch's own docs (2026-08-27) - GET
     * /helix/chat/pins.
     */
    public function getPinnedMessage(string $broadcasterId, string $moderatorId): ?PinnedChatMessage
    {
        $raw = $this->makeRequest('GET', '/chat/pins', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
        ]);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        return [] === $items ? null : PinnedChatMessage::from($items[0]);
    }

    /**
     * Get the active shared chat session for a channel.
     *
     * Requires: no scope
     *
     * Confirmed verbatim against Twitch's own docs (2026-08-27) - GET
     * /helix/shared_chat/session (singular). Real bug fixed here: this used
     * to call the non-existent /shared_chat/sessions (plural), which would
     * 404 on every call, broken since first written.
     */
    public function getSharedChatSession(string $broadcasterId): SharedChatSession
    {
        $raw = $this->makeRequest('GET', '/shared_chat/session', [
            'broadcaster_id' => $broadcasterId,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return SharedChatSession::from($items[0]);
    }

    /**
     * Get the color used for the user's name in chat.
     *
     * Requires: no scope
     *
     * @param string|array<string> $userIds One or more user IDs (max 100)
     *
     * @return DataCollection<int, ChatColor>
     */
    public function getUserChatColor(string|array $userIds): DataCollection
    {
        $raw = $this->makeRequest('GET', '/chat/color', [
            'user_id' => $userIds,
        ]);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, ChatColor> $dataCollection */
        $dataCollection = ChatColor::collect($items, DataCollection::class);

        return $dataCollection;
    }

    /**
     * Get emotes available to the user across all channels they follow/subscribe to.
     *
     * Requires: user:read:emotes
     *
     * Confirmed verbatim against Twitch's own docs (2026-08-27) - GET
     * /helix/chat/emotes/user. Real bug fixed here: this used to call the
     * non-existent /chat/user_emotes, which would 404 on every call, broken
     * since first written.
     *
     * @return PaginatedResult<Emote>
     */
    public function getUserEmotes(
        string $userId,
        ?string $broadcasterId = null,
        ?string $after = null,
    ): PaginatedResult {
        $params = ['user_id' => $userId];

        if (null !== $broadcasterId) {
            $params['broadcaster_id'] = $broadcasterId;
        }

        if (null !== $after) {
            $params['after'] = $after;
        }

        $raw = $this->makeRequest('GET', '/chat/emotes/user', $params);

        return PaginatedResult::fromRaw($raw, Emote::class);
    }

    /**
     * Pins a chat message to the top of the broadcaster's chat room. Only one
     * mod-pinned message can be active per channel - pinning a new one
     * automatically replaces any existing pin.
     *
     * Requires: moderator:manage:chat_messages
     *
     * Confirmed verbatim against Twitch's own docs (2026-08-27, official
     * example request/response) - PUT /helix/chat/pins, all params as query
     * string (not JSON body), 204 No Content on success, no response body.
     *
     * @param int|null $durationSeconds How long to pin for, 30-1800 seconds.
     *                                  Omit to pin until the stream ends.
     */
    public function pinMessage(
        string $broadcasterId,
        string $moderatorId,
        string $messageId,
        ?int $durationSeconds = null,
    ): void {
        $params = [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'message_id'     => $messageId,
        ];

        if (null !== $durationSeconds) {
            $params['duration_seconds'] = $durationSeconds;
        }

        $this->makeQueryRequest('PUT', '/chat/pins', $params);
    }

    /**
     * Send a colored announcement to the broadcaster's chat.
     *
     * Requires: moderator:manage:announcements
     *
     * @param string $color BLUE, GREEN, ORANGE, PURPLE, or PRIMARY
     */
    public function sendAnnouncement(
        string $broadcasterId,
        string $moderatorId,
        string $message,
        string $color = 'PRIMARY',
    ): void {
        $this->makeRequest('POST', '/chat/announcements', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'message'        => $message,
            'color'          => $color,
        ]);
    }

    /**
     * Send a message to a broadcaster's chat.
     *
     * Requires: user:write:chat (from sender)
     * If bot is not moderator: also needs channel:bot from broadcaster.
     *
     * @param string|null $replyParentMessageId ID of message to reply to
     * @param bool|null   $pin                  Send and pin in one call - requires
     *                                          moderator:manage:chat_messages, sender must be the
     *                                          broadcaster or a moderator, always pins for 20
     *                                          minutes (not configurable via this endpoint). Added
     *                                          2026-05-15 alongside the open-beta pin/unpin
     *                                          endpoints (Pin Chat Message, Get/Update Pinned Chat
     *                                          Message, Unpin Chat Message) - those four are NOT
     *                                          implemented here, Twitch's own reference page never
     *                                          rendered their exact request/response shape even
     *                                          via three independent lookup attempts, and no
     *                                          third-party Twitch API client had them either as of
     *                                          2026-08-27. Confirmed only via the changelog entry
     *                                          and Twitch's own dev forum, both of which describe
     *                                          the parameter but not the pin/unpin bodies -
     *                                          deliberately not guessing an unverified shape.
     */
    public function sendMessage(
        string $broadcasterId,
        string $senderId,
        string $message,
        ?string $replyParentMessageId = null,
        ?bool $pin = null,
    ): SentMessage {
        $body = [
            'broadcaster_id' => $broadcasterId,
            'sender_id'      => $senderId,
            'message'        => $message,
        ];

        if (null !== $replyParentMessageId) {
            $body['reply_parent_message_id'] = $replyParentMessageId;
        }

        if (null !== $pin) {
            $body['pin'] = $pin;
        }

        $raw = $this->makeRequest('POST', '/chat/messages', $body);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return SentMessage::from($items[0]);
    }

    /**
     * Send a shoutout to another broadcaster.
     *
     * Requires: moderator:manage:shoutouts
     */
    public function sendShoutout(
        string $fromBroadcasterId,
        string $toBroadcasterId,
        string $moderatorId,
    ): void {
        $this->makeRequest('POST', '/chat/shoutouts', [
            'from_broadcaster_id' => $fromBroadcasterId,
            'to_broadcaster_id'   => $toBroadcasterId,
            'moderator_id'        => $moderatorId,
        ]);
    }

    /**
     * Unpins a pinned chat message before its timer/stream-end would have.
     *
     * Requires: moderator:manage:chat_messages
     *
     * Confirmed verbatim against Twitch's own docs (2026-08-27) - DELETE
     * /helix/chat/pins, 204 No Content, no response body.
     */
    public function unpinMessage(string $broadcasterId, string $moderatorId, string $messageId): void
    {
        $this->makeRequest('DELETE', '/chat/pins', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'message_id'     => $messageId,
        ]);
    }

    /**
     * Update chat settings for a broadcaster's channel.
     *
     * Requires: moderator:manage:chat_settings
     */
    public function updateChatSettings(
        string $broadcasterId,
        string $moderatorId,
        UpdateChatSettingsRequest $updateChatSettingsRequest,
    ): ChatSettings {
        /** @var array<string, mixed> $requestData */
        $requestData = array_filter($updateChatSettingsRequest->toArray(), static fn (mixed $v): bool => null !== $v);

        $raw = $this->makeRequest('PATCH', '/chat/settings', array_merge([
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
        ], $requestData));

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return ChatSettings::from($items[0]);
    }

    /**
     * Updates the duration of an already-pinned chat message, starting from
     * now.
     *
     * Requires: moderator:manage:chat_messages
     *
     * Confirmed verbatim against Twitch's own docs (2026-08-27) - PATCH
     * /helix/chat/pins, all params as query string, 204 No Content, no
     * response body.
     *
     * @param int|null $durationSeconds New duration, 30-1800 seconds. Omit to
     *                                  pin until the stream ends.
     */
    public function updatePinnedMessage(
        string $broadcasterId,
        string $moderatorId,
        string $messageId,
        ?int $durationSeconds = null,
    ): void {
        $params = [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'message_id'     => $messageId,
        ];

        if (null !== $durationSeconds) {
            $params['duration_seconds'] = $durationSeconds;
        }

        $this->makeQueryRequest('PATCH', '/chat/pins', $params);
    }

    /**
     * Update the color used for the user's name in chat.
     *
     * Requires: user:manage:chat_color
     *
     * @param string $color Named color (blue, blue_violet, cadet_blue, chocolate, coral,
     *                      dodger_blue, firebrick, golden_rod, green, hot_pink, orange_red,
     *                      red, sea_green, spring_green, yellow_green) or hex (#RRGGBB for Turbo/Prime)
     */
    public function updateUserChatColor(string $userId, string $color): void
    {
        // makeQueryRequest: confirmed against Twitch's own docs - Update User
        // Chat Color takes user_id/color as query params on this PUT, not a
        // JSON body.
        $this->makeQueryRequest('PUT', '/chat/color', [
            'user_id' => $userId,
            'color'   => $color,
        ]);
    }
}
