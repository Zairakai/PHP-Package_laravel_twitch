<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub;

use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChatMessageEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelFollowEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelSubscribeEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\EventSubEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\GenericEventSubEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\StreamOfflineEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\StreamOnlineEvent;

/**
 * Resolves a raw EventSub notification into its typed DTO.
 *
 * Every subscription type is covered: types with a dedicated DTO get it,
 * everything else falls back to GenericEventSubEvent so no notification is
 * ever silently dropped or left untyped at the object level.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types
 */
final class EventSubEventFactory
{
    /**
     * @var array<string, class-string<EventSubEvent>>
     */
    private const array TYPE_MAP = [
        'channel.follow'       => ChannelFollowEvent::class,
        'channel.subscribe'    => ChannelSubscribeEvent::class,
        'channel.chat.message' => ChannelChatMessageEvent::class,
        'stream.online'        => StreamOnlineEvent::class,
        'stream.offline'       => StreamOfflineEvent::class,
    ];

    /**
     * @param string               $type    Subscription type as sent by Twitch (e.g. channel.follow)
     * @param array<string, mixed> $payload Raw `event` object from the notification
     */
    public static function make(string $type, array $payload): EventSubEvent
    {
        $class = self::TYPE_MAP[$type] ?? null;

        if (null === $class) {
            return GenericEventSubEvent::from([
                'type'    => $type,
                'payload' => $payload,
            ]);
        }

        return $class::from($payload);
    }
}
