<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Support;

/**
 * What the package knows about the versions of the EventSub subscription types.
 *
 * A subscription must name the version of its type, and the payload depends on it. Twitch refuses the versions it
 * has withdrawn (`channel.follow` v1 answers 410), so the default version is the latest one that the package's
 * DTOs read, not always `1`.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-reference/
 */
final class EventSubTypes
{
    /**
     * Types delivered in batches (`events` instead of `event` in the notification): Twitch requires
     * `is_batching_enabled` to be true for them.
     */
    private const array BATCHED = [
        'drop.entitlement.grant',
    ];

    /**
     * Types whose latest version is not `1`. The others only have version `1`.
     */
    private const array LATEST_VERSIONS = [
        'automod.message.hold'                                   => '2',
        'automod.message.update'                                 => '2',
        'channel.channel_points_automatic_reward_redemption.add' => '2',
        'channel.follow'                                         => '2',
        'channel.hype_train.begin'                               => '2',
        'channel.hype_train.end'                                 => '2',
        'channel.hype_train.progress'                            => '2',
        'channel.moderate'                                       => '2',
        'channel.update'                                         => '2',
    ];

    /**
     * Version to subscribe with when the caller does not give one.
     */
    public static function defaultVersion(string $type): string
    {
        return self::LATEST_VERSIONS[$type] ?? '1';
    }

    /**
     * Whether Twitch delivers this type in batches.
     */
    public static function isBatched(string $type): bool
    {
        return in_array(
            $type,
            self::BATCHED,
            true,
        );
    }
}
