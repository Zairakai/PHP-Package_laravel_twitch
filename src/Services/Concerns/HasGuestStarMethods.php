<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Services\Concerns;

use InvalidArgumentException;
use Spatie\LaravelData\DataCollection;
use Zairakai\LaravelTwitch\Dto\GuestStar\GuestStarInvite;
use Zairakai\LaravelTwitch\Dto\GuestStar\GuestStarSession;
use Zairakai\LaravelTwitch\Dto\GuestStar\GuestStarSettings;
use Zairakai\LaravelTwitch\Dto\GuestStar\Requests\UpdateGuestStarSettingsRequest;
use Zairakai\LaravelTwitch\Dto\GuestStar\Requests\UpdateGuestStarSlotSettingsRequest;

/**
 * Twitch Guest Star API methods.
 *
 * @see https://dev.twitch.tv/docs/api/reference/#get-channel-guest-star-settings
 */
trait HasGuestStarMethods
{
    /**
     * Assign a user to a slot in the active Guest Star session.
     *
     * Requires: channel:manage:guest_star or moderator:manage:guest_star
     */
    public function assignGuestStarSlot(
        string $broadcasterId,
        string $moderatorId,
        string $sessionId,
        string $guestId,
        string $slotId,
    ): void {
        $this->makeRequest('POST', '/guest_star/slot', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'session_id'     => $sessionId,
            'guest_id'       => $guestId,
            'slot_id'        => $slotId,
        ]);
    }

    /**
     * Create a new Guest Star session for the broadcaster.
     *
     * Requires: channel:manage:guest_star
     */
    public function createGuestStarSession(string $broadcasterId): GuestStarSession
    {
        $raw = $this->makeRequest('POST', '/guest_star/session', [
            'broadcaster_id' => $broadcasterId,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return GuestStarSession::from($items[0]);
    }

    /**
     * Revoke a previously sent Guest Star invitation for a user.
     *
     * Requires: channel:manage:guest_star or moderator:manage:guest_star
     */
    public function deleteGuestStarInvite(
        string $broadcasterId,
        string $moderatorId,
        string $sessionId,
        string $guestId,
    ): void {
        $this->makeRequest('DELETE', '/guest_star/invites', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'session_id'     => $sessionId,
            'guest_id'       => $guestId,
        ]);
    }

    /**
     * Remove a user from their slot in the active Guest Star session.
     *
     * Requires: channel:manage:guest_star or moderator:manage:guest_star
     *
     * @param bool|null $shouldReinviteGuest Send the guest back to the invite queue instead of dropping them
     */
    public function deleteGuestStarSlot(
        string $broadcasterId,
        string $moderatorId,
        string $sessionId,
        string $guestId,
        string $slotId,
        ?bool $shouldReinviteGuest = null,
    ): void {
        $this->makeRequest('DELETE', '/guest_star/slot', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'session_id'     => $sessionId,
            'guest_id'       => $guestId,
            'slot_id'        => $slotId,
            ...(null === $shouldReinviteGuest ? [] : [
                'should_reinvite_guest' => $shouldReinviteGuest ? 'true' : 'false',
            ]),
        ]);
    }

    /**
     * End an active Guest Star session for the broadcaster.
     *
     * Requires: channel:manage:guest_star
     */
    public function endGuestStarSession(string $broadcasterId, string $sessionId): GuestStarSession
    {
        $raw = $this->makeRequest('DELETE', '/guest_star/session', [
            'broadcaster_id' => $broadcasterId,
            'session_id'     => $sessionId,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        return GuestStarSession::from($items[0]);
    }

    /**
     * Get settings for the broadcaster's Guest Star feature.
     *
     * Requires: channel:read:guest_star or moderator:read:guest_star
     */
    public function getChannelGuestStarSettings(
        string $broadcasterId,
        string $moderatorId,
    ): GuestStarSettings {
        $raw = $this->makeRequest('GET', '/guest_star/channel_settings', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
        ]);

        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'];

        // Twitch does not send the broadcaster ID back.
        return GuestStarSettings::from([
            'broadcaster_id' => $broadcasterId,
            ...$items[0],
        ]);
    }

    /**
     * Get a list of pending invitations for a Guest Star session.
     *
     * Requires: channel:read:guest_star, moderator:read:guest_star,
     *           channel:manage:guest_star, or moderator:manage:guest_star
     *
     * @return DataCollection<int, GuestStarInvite>
     */
    public function getGuestStarInvites(
        string $broadcasterId,
        string $moderatorId,
        string $sessionId,
    ): DataCollection {
        $raw = $this->makeRequest('GET', '/guest_star/invites', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'session_id'     => $sessionId,
        ]);

        /** @var list<array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        /** @var DataCollection<int, GuestStarInvite> $dataCollection */
        $dataCollection = GuestStarInvite::collect($items, DataCollection::class);

        return $dataCollection;
    }

    /**
     * Get the active Guest Star session for the broadcaster's channel.
     *
     * Requires: channel:read:guest_star, moderator:read:guest_star,
     *           channel:manage:guest_star, or moderator:manage:guest_star
     */
    public function getGuestStarSession(
        string $broadcasterId,
        string $moderatorId,
    ): ?GuestStarSession {
        $raw = $this->makeRequest('GET', '/guest_star/session', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
        ]);

        // Twitch answers an empty list when there is no active session (or the caller may not see it).
        /** @var array<int, array<string, mixed>> $items */
        $items = $raw['data'] ?? [];

        return isset($items[0])
            ? GuestStarSession::from($items[0])
            : null;
    }

    /**
     * Send an invitation to a specified user to be a guest for a Guest Star session.
     *
     * Requires: channel:manage:guest_star or moderator:manage:guest_star
     */
    public function sendGuestStarInvite(
        string $broadcasterId,
        string $moderatorId,
        string $sessionId,
        string $guestId,
    ): void {
        $this->makeRequest('POST', '/guest_star/invites', [
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'session_id'     => $sessionId,
            'guest_id'       => $guestId,
        ]);
    }

    /**
     * Update settings for the broadcaster's Guest Star feature.
     *
     * Requires: channel:manage:guest_star
     */
    public function updateChannelGuestStarSettings(
        string $broadcasterId,
        string $moderatorId,
        UpdateGuestStarSettingsRequest $updateGuestStarSettingsRequest,
    ): void {
        /** @var array<string, mixed> $settingsData */
        $settingsData = array_filter(
            $updateGuestStarSettingsRequest->toArray(),
            static fn (mixed $v): bool => null !== $v,
        );

        // Twitch documents this route with `broadcaster_id` only (the token user must be the broadcaster): no moderator.
        unset($settingsData['broadcaster_audio_setting']);

        $this->makeRequest('PATCH', '/guest_star/channel_settings', array_merge([
            'broadcaster_id' => $broadcasterId,
        ], $settingsData));
    }

    /**
     * Move a user from one Guest Star slot to another in the active session.
     *
     * Requires: channel:manage:guest_star or moderator:manage:guest_star
     */
    public function updateGuestStarSlot(
        string $broadcasterId,
        string $moderatorId,
        string $sessionId,
        string $sourceSlotId,
        ?string $destinationSlotId = null,
    ): void {
        $params = [
            'broadcaster_id'  => $broadcasterId,
            'moderator_id'    => $moderatorId,
            'session_id'      => $sessionId,
            'source_slot_id'  => $sourceSlotId,
        ];

        if (null === $destinationSlotId) {
            throw new InvalidArgumentException(
                'updateGuestStarSlot() needs a destination slot ID (Twitch requires it).',
            );
        }

        $params['destination_slot_id'] = $destinationSlotId;

        $this->makeRequest(
            'PATCH',
            '/guest_star/slot',
            $params,
        );
    }

    /**
     * Update settings for a Guest Star slot in the active session.
     *
     * Requires: channel:manage:guest_star or moderator:manage:guest_star
     */
    public function updateGuestStarSlotSettings(
        string $broadcasterId,
        string $moderatorId,
        string $sessionId,
        string $slotId,
        UpdateGuestStarSlotSettingsRequest $updateGuestStarSlotSettingsRequest,
    ): void {
        /** @var array<string, mixed> $settingsData */
        $settingsData = array_filter(
            $updateGuestStarSlotSettingsRequest->toArray(),
            static fn (mixed $v): bool => null !== $v,
        );

        // Twitch dropped `volume` from the reference (2026-11-10: not supported): never sent.
        unset($settingsData['volume']);

        $this->makeRequest('PATCH', '/guest_star/slot_settings', array_merge([
            'broadcaster_id' => $broadcasterId,
            'moderator_id'   => $moderatorId,
            'session_id'     => $sessionId,
            'slot_id'        => $slotId,
        ], $settingsData));
    }
}
