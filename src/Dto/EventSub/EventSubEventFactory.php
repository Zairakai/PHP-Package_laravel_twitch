<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Dto\EventSub;

use Zairakai\LaravelTwitch\Dto\EventSub\Events\AutomodMessageUpdateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\AutomodSettingsUpdateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\AutomodTermsUpdateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelAdBreakBeginEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelBanEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelBitsUseEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChannelPointsAutomaticRewardRedemptionAddEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChannelPointsCustomRewardAddEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChannelPointsCustomRewardRemoveEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChannelPointsCustomRewardUpdateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelCharityCampaignDonateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelCharityCampaignProgressEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelCharityCampaignStartEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelCharityCampaignStopEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChatClearEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChatClearUserMessagesEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChatMessageDeleteEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChatMessageEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChatNotificationEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChatSettingsUpdateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChatUserMessageHoldEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelChatUserMessageUpdateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelCheerEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelCustomPowerUpRedemptionAddEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelFollowEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelGoalBeginEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelGoalEndEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelGoalProgressEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelGuestStarGuestUpdateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelGuestStarSessionBeginEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelGuestStarSessionEndEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelGuestStarSettingsUpdateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelHypeTrainBeginEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelHypeTrainEndEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelHypeTrainProgressEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelModerateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelModeratorAddEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelModeratorRemoveEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelPointsRedemptionEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelPollBeginEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelPollEndEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelPollProgressEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelPredictionBeginEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelPredictionEndEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelPredictionLockEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelPredictionProgressEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelRaidEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelSharedChatBeginEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelSharedChatEndEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelSharedChatUpdateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelShieldModeBeginEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelShieldModeEndEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelShoutoutCreateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelShoutoutReceiveEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelSubscribeEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelSubscriptionEndEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelSubscriptionGiftEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelSubscriptionMessageEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelSuspiciousUserMessageEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelSuspiciousUserUpdateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelUnbanEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelUnbanRequestCreateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelUnbanRequestResolveEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelUpdateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelVipAddEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelVipRemoveEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelWarningAcknowledgeEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ChannelWarningSendEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ConduitShardDisabledEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\EventSubEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\ExtensionBitsTransactionCreateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\GenericEventSubEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\StreamOfflineEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\StreamOnlineEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\UserAuthorizationGrantEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\UserAuthorizationRevokeEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\UserUpdateEvent;
use Zairakai\LaravelTwitch\Dto\EventSub\Events\UserWhisperMessageEvent;

/**
 * Resolves a raw EventSub notification into its typed DTO.
 *
 * Covers the full EventSub subscription type catalog (77 types, verified
 * against the official example payloads on 2026-08-09, `channel.bits.use`
 * added 2026-08-13 - `drop.entitlement.grant` deliberately left out: it is
 * organization/campaign-scoped, not broadcaster-scoped, and its exact
 * payload shape is not fully published in the official docs). Any future type
 * Twitch adds before this factory is updated still falls back to
 * GenericEventSubEvent - no notification is ever silently dropped or left
 * untyped at the object level.
 *
 * @see https://dev.twitch.tv/docs/eventsub/eventsub-subscription-types
 */
final class EventSubEventFactory
{
    /**
     * @var array<string, class-string<EventSubEvent>>
     */
    private const array TYPE_MAP = [
        'automod.message.update'                                 => AutomodMessageUpdateEvent::class,
        'automod.settings.update'                                => AutomodSettingsUpdateEvent::class,
        'automod.terms.update'                                   => AutomodTermsUpdateEvent::class,
        'channel.ad_break.begin'                                 => ChannelAdBreakBeginEvent::class,
        'channel.ban'                                            => ChannelBanEvent::class,
        'channel.bits.use'                                       => ChannelBitsUseEvent::class,
        'channel.channel_points_automatic_reward_redemption.add' => ChannelChannelPointsAutomaticRewardRedemptionAddEvent::class,
        'channel.channel_points_custom_reward.add'               => ChannelChannelPointsCustomRewardAddEvent::class,
        'channel.channel_points_custom_reward.remove'            => ChannelChannelPointsCustomRewardRemoveEvent::class,
        'channel.channel_points_custom_reward.update'            => ChannelChannelPointsCustomRewardUpdateEvent::class,
        'channel.channel_points_custom_reward_redemption.add'    => ChannelPointsRedemptionEvent::class,
        'channel.channel_points_custom_reward_redemption.update' => ChannelPointsRedemptionEvent::class,
        'channel.charity_campaign.donate'                        => ChannelCharityCampaignDonateEvent::class,
        'channel.charity_campaign.progress'                      => ChannelCharityCampaignProgressEvent::class,
        'channel.charity_campaign.start'                         => ChannelCharityCampaignStartEvent::class,
        'channel.charity_campaign.stop'                          => ChannelCharityCampaignStopEvent::class,
        'channel.chat.clear'                                     => ChannelChatClearEvent::class,
        'channel.chat.clear_user_messages'                       => ChannelChatClearUserMessagesEvent::class,
        'channel.chat.message'                                   => ChannelChatMessageEvent::class,
        'channel.chat.message_delete'                            => ChannelChatMessageDeleteEvent::class,
        'channel.chat.notification'                              => ChannelChatNotificationEvent::class,
        'channel.chat.user_message_hold'                         => ChannelChatUserMessageHoldEvent::class,
        'channel.chat.user_message_update'                       => ChannelChatUserMessageUpdateEvent::class,
        'channel.chat_settings.update'                           => ChannelChatSettingsUpdateEvent::class,
        'channel.cheer'                                          => ChannelCheerEvent::class,
        'channel.custom_power_up_redemption.add'                 => ChannelCustomPowerUpRedemptionAddEvent::class,
        'channel.follow'                                         => ChannelFollowEvent::class,
        'channel.goal.begin'                                     => ChannelGoalBeginEvent::class,
        'channel.goal.end'                                       => ChannelGoalEndEvent::class,
        'channel.goal.progress'                                  => ChannelGoalProgressEvent::class,
        'channel.guest_star_guest.update'                        => ChannelGuestStarGuestUpdateEvent::class,
        'channel.guest_star_session.begin'                       => ChannelGuestStarSessionBeginEvent::class,
        'channel.guest_star_session.end'                         => ChannelGuestStarSessionEndEvent::class,
        'channel.guest_star_settings.update'                     => ChannelGuestStarSettingsUpdateEvent::class,
        'channel.hype_train.begin'                               => ChannelHypeTrainBeginEvent::class,
        'channel.hype_train.end'                                 => ChannelHypeTrainEndEvent::class,
        'channel.hype_train.progress'                            => ChannelHypeTrainProgressEvent::class,
        'channel.moderate'                                       => ChannelModerateEvent::class,
        'channel.moderator.add'                                  => ChannelModeratorAddEvent::class,
        'channel.moderator.remove'                               => ChannelModeratorRemoveEvent::class,
        'channel.poll.begin'                                     => ChannelPollBeginEvent::class,
        'channel.poll.end'                                       => ChannelPollEndEvent::class,
        'channel.poll.progress'                                  => ChannelPollProgressEvent::class,
        'channel.prediction.begin'                               => ChannelPredictionBeginEvent::class,
        'channel.prediction.end'                                 => ChannelPredictionEndEvent::class,
        'channel.prediction.lock'                                => ChannelPredictionLockEvent::class,
        'channel.prediction.progress'                            => ChannelPredictionProgressEvent::class,
        'channel.raid'                                           => ChannelRaidEvent::class,
        'channel.shared_chat.begin'                              => ChannelSharedChatBeginEvent::class,
        'channel.shared_chat.end'                                => ChannelSharedChatEndEvent::class,
        'channel.shared_chat.update'                             => ChannelSharedChatUpdateEvent::class,
        'channel.shield_mode.begin'                              => ChannelShieldModeBeginEvent::class,
        'channel.shield_mode.end'                                => ChannelShieldModeEndEvent::class,
        'channel.shoutout.create'                                => ChannelShoutoutCreateEvent::class,
        'channel.shoutout.receive'                               => ChannelShoutoutReceiveEvent::class,
        'channel.subscribe'                                      => ChannelSubscribeEvent::class,
        'channel.subscription.end'                               => ChannelSubscriptionEndEvent::class,
        'channel.subscription.gift'                              => ChannelSubscriptionGiftEvent::class,
        'channel.subscription.message'                           => ChannelSubscriptionMessageEvent::class,
        'channel.suspicious_user.message'                        => ChannelSuspiciousUserMessageEvent::class,
        'channel.suspicious_user.update'                         => ChannelSuspiciousUserUpdateEvent::class,
        'channel.unban'                                          => ChannelUnbanEvent::class,
        'channel.unban_request.create'                           => ChannelUnbanRequestCreateEvent::class,
        'channel.unban_request.resolve'                          => ChannelUnbanRequestResolveEvent::class,
        'channel.update'                                         => ChannelUpdateEvent::class,
        'channel.vip.add'                                        => ChannelVipAddEvent::class,
        'channel.vip.remove'                                     => ChannelVipRemoveEvent::class,
        'channel.warning.acknowledge'                            => ChannelWarningAcknowledgeEvent::class,
        'channel.warning.send'                                   => ChannelWarningSendEvent::class,
        'conduit.shard.disabled'                                 => ConduitShardDisabledEvent::class,
        'extension.bits_transaction.create'                      => ExtensionBitsTransactionCreateEvent::class,
        'stream.offline'                                         => StreamOfflineEvent::class,
        'stream.online'                                          => StreamOnlineEvent::class,
        'user.authorization.grant'                               => UserAuthorizationGrantEvent::class,
        'user.authorization.revoke'                              => UserAuthorizationRevokeEvent::class,
        'user.update'                                            => UserUpdateEvent::class,
        'user.whisper.message'                                   => UserWhisperMessageEvent::class,
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
