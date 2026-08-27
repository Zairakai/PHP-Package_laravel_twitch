<?php

declare(strict_types=1);

namespace Zairakai\LaravelTwitch\Facades;

use Illuminate\Support\Facades\Facade;
use Spatie\LaravelData\DataCollection;
use Zairakai\LaravelTwitch\Dto\Ads\AdSchedule;
use Zairakai\LaravelTwitch\Dto\Ads\AdSnooze;
use Zairakai\LaravelTwitch\Dto\Ads\CommercialResult;
use Zairakai\LaravelTwitch\Dto\Analytics\ExtensionAnalytics;
use Zairakai\LaravelTwitch\Dto\Analytics\GameAnalytics;
use Zairakai\LaravelTwitch\Dto\Bits\BitsLeaderboardEntry;
use Zairakai\LaravelTwitch\Dto\Bits\Cheermote;
use Zairakai\LaravelTwitch\Dto\Bits\ExtensionTransaction;
use Zairakai\LaravelTwitch\Dto\Channel\Channel;
use Zairakai\LaravelTwitch\Dto\Channel\ChannelEditor;
use Zairakai\LaravelTwitch\Dto\Channel\Requests\CreateScheduleSegmentRequest;
use Zairakai\LaravelTwitch\Dto\Channel\Requests\UpdateChannelRequest;
use Zairakai\LaravelTwitch\Dto\Channel\Requests\UpdateScheduleSegmentRequest;
use Zairakai\LaravelTwitch\Dto\Channel\Requests\UpdateScheduleSettingsRequest;
use Zairakai\LaravelTwitch\Dto\Channel\Schedule;
use Zairakai\LaravelTwitch\Dto\Channel\ScheduleSegment;
use Zairakai\LaravelTwitch\Dto\Channel\SearchChannel;
use Zairakai\LaravelTwitch\Dto\ChannelPoints\CustomReward;
use Zairakai\LaravelTwitch\Dto\ChannelPoints\Redemption;
use Zairakai\LaravelTwitch\Dto\ChannelPoints\Requests\CreateCustomRewardRequest;
use Zairakai\LaravelTwitch\Dto\ChannelPoints\Requests\UpdateCustomRewardRequest;
use Zairakai\LaravelTwitch\Dto\Charity\CharityCampaign;
use Zairakai\LaravelTwitch\Dto\Charity\CharityDonation;
use Zairakai\LaravelTwitch\Dto\Chat\Badge;
use Zairakai\LaravelTwitch\Dto\Chat\ChatColor;
use Zairakai\LaravelTwitch\Dto\Chat\ChatSettings;
use Zairakai\LaravelTwitch\Dto\Chat\Chatter;
use Zairakai\LaravelTwitch\Dto\Chat\Emote;
use Zairakai\LaravelTwitch\Dto\Chat\Requests\UpdateChatSettingsRequest;
use Zairakai\LaravelTwitch\Dto\Chat\SentMessage;
use Zairakai\LaravelTwitch\Dto\Chat\SharedChatSession;
use Zairakai\LaravelTwitch\Dto\Conduits\Conduit;
use Zairakai\LaravelTwitch\Dto\Conduits\ConduitShard;
use Zairakai\LaravelTwitch\Dto\Conduits\Requests\UpdateConduitShardRequest;
use Zairakai\LaravelTwitch\Dto\ContentLabels\ContentClassificationLabel;
use Zairakai\LaravelTwitch\Dto\Drops\DropsEntitlement;
use Zairakai\LaravelTwitch\Dto\Drops\EntitlementStatus;
use Zairakai\LaravelTwitch\Dto\EventSub\Subscription as EventSubSubscription;
use Zairakai\LaravelTwitch\Dto\Games\Game;
use Zairakai\LaravelTwitch\Dto\Goals\Goal;
use Zairakai\LaravelTwitch\Dto\GuestStar\GuestStarInvite;
use Zairakai\LaravelTwitch\Dto\GuestStar\GuestStarSession;
use Zairakai\LaravelTwitch\Dto\GuestStar\GuestStarSettings;
use Zairakai\LaravelTwitch\Dto\GuestStar\Requests\UpdateGuestStarSettingsRequest;
use Zairakai\LaravelTwitch\Dto\GuestStar\Requests\UpdateGuestStarSlotSettingsRequest;
use Zairakai\LaravelTwitch\Dto\HypeTrain\HypeTrainStatus;
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
use Zairakai\LaravelTwitch\Dto\Polls\Poll;
use Zairakai\LaravelTwitch\Dto\Polls\Requests\CreatePollRequest;
use Zairakai\LaravelTwitch\Dto\Predictions\Prediction;
use Zairakai\LaravelTwitch\Dto\Predictions\Requests\CreatePredictionRequest;
use Zairakai\LaravelTwitch\Dto\Raids\Raid;
use Zairakai\LaravelTwitch\Dto\Streams\Clip;
use Zairakai\LaravelTwitch\Dto\Streams\ClipDownload;
use Zairakai\LaravelTwitch\Dto\Streams\ClipEdit;
use Zairakai\LaravelTwitch\Dto\Streams\Stream;
use Zairakai\LaravelTwitch\Dto\Streams\StreamKey;
use Zairakai\LaravelTwitch\Dto\Streams\StreamMarker;
use Zairakai\LaravelTwitch\Dto\Streams\StreamMarkerGroup;
use Zairakai\LaravelTwitch\Dto\Streams\Video;
use Zairakai\LaravelTwitch\Dto\Teams\Team;
use Zairakai\LaravelTwitch\Dto\Users\BlockedUser;
use Zairakai\LaravelTwitch\Dto\Users\FollowedChannel;
use Zairakai\LaravelTwitch\Dto\Users\Follower;
use Zairakai\LaravelTwitch\Dto\Users\Subscription;
use Zairakai\LaravelTwitch\Dto\Users\SubscriptionCheck;
use Zairakai\LaravelTwitch\Dto\Users\User;
use Zairakai\LaravelTwitch\Dto\Users\UserAuthorization;
use Zairakai\LaravelTwitch\Services\TwitchApiService;

/**
 * Twitch API Facade.
 *
 * Provides static access to all Twitch Helix API methods via TwitchApiService.
 *
 * @see TwitchApiService
 *
 * ── Core ──────────────────────────────────────────────────────────────────────
 *
 * @method static TwitchApiService setAccessToken(string $token)
 * @method static string           getAppAccessToken()
 * @method static array|null       getGame(string $gameId)
 * @method static array|null       getStream(string $userId)
 * @method static array|null       getUser(int|string $identifier)
 *
 * ── Ads (HasAdsMethods) ───────────────────────────────────────────────────────
 * @method static AdSchedule       getAdSchedule(string $broadcasterId)
 * @method static AdSnooze         snoozeNextAd(string $broadcasterId)
 * @method static CommercialResult startCommercial(string $broadcasterId, int $length)
 *
 * ── Analytics (HasAnalyticsMethods) ──────────────────────────────────────────
 * @method static PaginatedResult<ExtensionAnalytics> getExtensionAnalytics(string|null $extensionId = null, string $type = 'overview_v2', string|null $startedAt = null, string|null $endedAt = null, int $first = 20, string|null $after = null)
 * @method static PaginatedResult<GameAnalytics>      getGameAnalytics(string|null $gameId = null, string $type = 'overview_v2', string|null $startedAt = null, string|null $endedAt = null, int $first = 20, string|null $after = null)
 *
 * ── Bits & Cheermotes (HasBitsMethods) ────────────────────────────────────────
 * @method static DataCollection<int, BitsLeaderboardEntry>  getBitsLeaderboard(int $count = 10, string $period = 'ALL', string|null $userId = null, string|null $startedAt = null)
 * @method static DataCollection<int, Cheermote>             getCheermotes(string|null $broadcasterId = null)
 * @method static PaginatedResult<ExtensionTransaction>      getExtensionTransactions(string $extensionId, string|array<string>|null $transactionIds = null, string|null $after = null, int $first = 20)
 *
 * ── Channel (HasChannelMethods) ───────────────────────────────────────────────
 * @method static DataCollection<int, Channel>        getChannel(string|array<string> $broadcasterIds)
 * @method static void                                updateChannel(string $broadcasterId, UpdateChannelRequest $request)
 * @method static DataCollection<int, ChannelEditor>  getChannelEditors(string $broadcasterId)
 * @method static PaginatedResult<SearchChannel>      searchChannels(string $query, int $first = 20, string|null $after = null, bool $liveOnly = false)
 * @method static Schedule                            getSchedule(string $broadcasterId, string|null $segmentId = null, int $first = 20, string|null $after = null)
 * @method static string                              getScheduleCalendar(string $broadcasterId)
 * @method static void                                updateScheduleSettings(string $broadcasterId, UpdateScheduleSettingsRequest $request)
 * @method static ScheduleSegment                     createScheduleSegment(string $broadcasterId, CreateScheduleSegmentRequest $request)
 * @method static ScheduleSegment                     updateScheduleSegment(string $broadcasterId, string $segmentId, UpdateScheduleSegmentRequest $request)
 * @method static void                                deleteScheduleSegment(string $broadcasterId, string $segmentId)
 *
 * ── Channel Points (HasChannelPointsMethods) ──────────────────────────────────
 * @method static DataCollection<int, CustomReward>  getCustomRewards(string $broadcasterId, string|array<string>|null $rewardIds = null, bool $onlyManageable = false)
 * @method static CustomReward                       createCustomReward(string $broadcasterId, CreateCustomRewardRequest $request)
 * @method static CustomReward                       updateCustomReward(string $broadcasterId, string $rewardId, UpdateCustomRewardRequest $request)
 * @method static void                               deleteCustomReward(string $broadcasterId, string $rewardId)
 * @method static PaginatedResult<Redemption>        getRedemptions(string $broadcasterId, string $rewardId, string|null $status = null, string|array<string>|null $redemptionIds = null, int $first = 20, string|null $after = null)
 * @method static DataCollection<int, Redemption>   updateRedemptionStatus(string $broadcasterId, string $rewardId, string|array<string> $redemptionIds, string $status)
 *
 * ── Charity (HasCharityMethods) ───────────────────────────────────────────────
 * @method static CharityCampaign                getCharityCampaign(string $broadcasterId)
 * @method static PaginatedResult<CharityDonation> getCharityCampaignDonations(string $broadcasterId, int $first = 20, string|null $after = null)
 *
 * ── Chat (HasChatMethods) ─────────────────────────────────────────────────────
 * @method static SentMessage                      sendMessage(string $broadcasterId, string $senderId, string $message, string|null $replyParentMessageId = null)
 * @method static void                             deleteMessage(string $broadcasterId, string $moderatorId, string|null $messageId = null)
 * @method static void                             clearChat(string $broadcasterId, string $moderatorId)
 * @method static void                             sendAnnouncement(string $broadcasterId, string $moderatorId, string $message, string $color = 'PRIMARY')
 * @method static void                             sendShoutout(string $fromBroadcasterId, string $toBroadcasterId, string $moderatorId)
 * @method static ChatSettings                     getChatSettings(string $broadcasterId, string|null $moderatorId = null)
 * @method static ChatSettings                     updateChatSettings(string $broadcasterId, string $moderatorId, UpdateChatSettingsRequest $request)
 * @method static PaginatedResult<Chatter>         getChatters(string $broadcasterId, string $moderatorId, int $first = 100, string|null $after = null)
 * @method static DataCollection<int, Emote>       getChannelEmotes(string $broadcasterId)
 * @method static DataCollection<int, Emote>       getGlobalEmotes()
 * @method static DataCollection<int, Emote>       getEmoteSets(string|array<string> $emoteSetIds)
 * @method static DataCollection<int, Badge>       getChannelBadges(string $broadcasterId)
 * @method static DataCollection<int, Badge>       getGlobalBadges()
 * @method static SharedChatSession                getSharedChatSession(string $broadcasterId)
 * @method static PaginatedResult<Emote>           getUserEmotes(string $userId, string|null $broadcasterId = null, string|null $after = null)
 * @method static DataCollection<int, ChatColor>   getUserChatColor(string|array<string> $userIds)
 * @method static void                             updateUserChatColor(string $userId, string $color)
 *
 * ── Conduits (HasConduitsMethods) ─────────────────────────────────────────────
 * @method static DataCollection<int, Conduit>    getConduits()
 * @method static Conduit                         createConduit(int $shardCount)
 * @method static Conduit                         updateConduit(string $conduitId, int $shardCount)
 * @method static void                            deleteConduit(string $conduitId)
 * @method static PaginatedResult<ConduitShard>   getConduitShards(string $conduitId, string|null $status = null, string|null $after = null)
 * @method static DataCollection<int, ConduitShard> updateConduitShards(string $conduitId, list<UpdateConduitShardRequest> $shards)
 *
 * ── Content Classification Labels (HasContentLabelsMethods) ───────────────────
 * @method static DataCollection<int, ContentClassificationLabel> getContentClassificationLabels(string $locale = 'en-US')
 *
 * ── Drops (HasDropsMethods) ───────────────────────────────────────────────────
 * @method static PaginatedResult<DropsEntitlement>    getDropsEntitlements(string|array<string>|null $ids = null, string|null $userId = null, string|null $gameId = null, string|null $fulfillmentStatus = null, int $first = 20, string|null $after = null)
 * @method static DataCollection<int, EntitlementStatus> updateDropsEntitlements(array $entitlementIds, string $fulfillmentStatus)
 *
 * ── EventSub (HasEventSubMethods) ─────────────────────────────────────────────
 * @method static PaginatedResult<EventSubSubscription> getEventSubSubscriptions(string|null $type = null, string|null $status = null, int $first = 100, string|null $after = null)
 * @method static EventSubSubscription                  createEventSubSubscription(string $type, array $condition, string $callbackUrl, string $secret, string $version = '1')
 * @method static EventSubSubscription                  createEventSubWebSocketSubscription(string $type, array $condition, string $sessionId, string $version = '1')
 * @method static void                                  deleteEventSubSubscription(string $subscriptionId)
 * @method static PaginatedResult<EventSubSubscription> getEventSubSubscriptionsByType(string $type)
 * @method static int                                   deleteEventSubSubscriptionsByType(string $type)
 *
 * ── Games & Categories (HasGameMethods) ───────────────────────────────────────
 * @method static DataCollection<int, Game> getGames(string|array<string>|null $ids = null, string|array<string>|null $names = null)
 * @method static PaginatedResult<Game>     getTopGames(int $first = 20, string|null $after = null)
 * @method static PaginatedResult<Game>     searchCategories(string $query, int $first = 20, string|null $after = null)
 *
 * ── Goals (HasGoalsMethods) ───────────────────────────────────────────────────
 * @method static DataCollection<int, Goal> getCreatorGoals(string $broadcasterId)
 *
 * ── Guest Star (HasGuestStarMethods) ──────────────────────────────────────────
 * @method static GuestStarSettings             getChannelGuestStarSettings(string $broadcasterId, string $moderatorId)
 * @method static void                          updateChannelGuestStarSettings(string $broadcasterId, string $moderatorId, UpdateGuestStarSettingsRequest $settings)
 * @method static GuestStarSession              getGuestStarSession(string $broadcasterId, string $moderatorId)
 * @method static GuestStarSession              createGuestStarSession(string $broadcasterId)
 * @method static GuestStarSession              endGuestStarSession(string $broadcasterId, string $sessionId)
 * @method static DataCollection<int, GuestStarInvite> getGuestStarInvites(string $broadcasterId, string $moderatorId, string $sessionId)
 * @method static void                          sendGuestStarInvite(string $broadcasterId, string $moderatorId, string $sessionId, string $guestId)
 * @method static void                          deleteGuestStarInvite(string $broadcasterId, string $moderatorId, string $sessionId, string $guestId)
 * @method static void                          assignGuestStarSlot(string $broadcasterId, string $moderatorId, string $sessionId, string $guestId, string $slotId)
 * @method static void                          updateGuestStarSlot(string $broadcasterId, string $moderatorId, string $sessionId, string $sourceSlotId, string|null $destinationSlotId = null)
 * @method static void                          deleteGuestStarSlot(string $broadcasterId, string $moderatorId, string $sessionId, string $guestId, string $slotId)
 * @method static void                          updateGuestStarSlotSettings(string $broadcasterId, string $moderatorId, string $sessionId, string $slotId, UpdateGuestStarSlotSettingsRequest $settings)
 *
 * ── Moderation (HasModerationMethods) ────────────────────────────────────────
 * @method static BanResult                               banUser(string $broadcasterId, string $moderatorId, string $userId, string|null $reason = null)
 * @method static BanResult                               timeoutUser(string $broadcasterId, string $moderatorId, string $userId, int $duration, string|null $reason = null)
 * @method static void                                    unbanUser(string $broadcasterId, string $moderatorId, string $userId)
 * @method static WarnedUser                              warnUser(string $broadcasterId, string $moderatorId, string $userId, string|null $reason = null)
 * @method static PaginatedResult<BannedUser>             getBannedUsers(string $broadcasterId, string|null $userId = null, int $first = 20, string|null $after = null)
 * @method static PaginatedResult<Moderator>              getModerators(string $broadcasterId, string|null $userId = null, int $first = 20, string|null $after = null)
 * @method static void                                    addModerator(string $broadcasterId, string $userId)
 * @method static void                                    removeModerator(string $broadcasterId, string $userId)
 * @method static PaginatedResult<Vip>                    getVips(string $broadcasterId, string|null $userId = null, int $first = 20, string|null $after = null)
 * @method static void                                    addVip(string $broadcasterId, string $userId)
 * @method static void                                    removeVip(string $broadcasterId, string $userId)
 * @method static PaginatedResult<BlockedTerm>            getBlockedTerms(string $broadcasterId, string $moderatorId, int $first = 20, string|null $after = null)
 * @method static BlockedTerm                             addBlockedTerm(string $broadcasterId, string $moderatorId, string $text)
 * @method static void                                    removeBlockedTerm(string $broadcasterId, string $moderatorId, string $termId)
 * @method static AutoModSettings                         getAutoModSettings(string $broadcasterId, string $moderatorId)
 * @method static AutoModSettings                         updateAutoModSettings(string $broadcasterId, string $moderatorId, UpdateAutoModSettingsRequest $request)
 * @method static ShieldMode                              getShieldMode(string $broadcasterId, string $moderatorId)
 * @method static ShieldMode                              setShieldMode(string $broadcasterId, string $moderatorId, bool $isActive)
 * @method static void                                    manageHeldMessage(string $userId, string $msgId, string $action)
 * @method static DataCollection<int, AutoModCheckResult> checkAutoModStatus(string $broadcasterId, list<AutoModMessageRequest> $messages)
 * @method static PaginatedResult<UnbanRequest>           getUnbanRequests(string $broadcasterId, string $moderatorId, string $status, string|null $userId = null, string|null $after = null, int $first = 20)
 * @method static UnbanRequest                            resolveUnbanRequest(string $broadcasterId, string $moderatorId, string $unbanRequestId, string $status, string|null $resolution = null)
 * @method static PaginatedResult<ModeratedChannel>       getModeratedChannels(string $userId, string|null $after = null, int $first = 20)
 * @method static SuspiciousUser                          addSuspiciousUser(string $broadcasterId, string $moderatorId, string $targetUserId, string $status)
 * @method static void                                    removeSuspiciousUser(string $broadcasterId, string $moderatorId, string $targetUserId)
 *
 * ── Polls (HasPollMethods) ────────────────────────────────────────────────────
 * @method static PaginatedResult<Poll> getPolls(string $broadcasterId, string|array<string>|null $pollIds = null, int $first = 20, string|null $after = null)
 * @method static Poll                  createPoll(CreatePollRequest $request)
 * @method static Poll                  endPoll(string $broadcasterId, string $pollId, string $status = 'TERMINATED')
 *
 * ── Predictions (HasPredictionMethods) ────────────────────────────────────────
 * @method static PaginatedResult<Prediction> getPredictions(string $broadcasterId, string|array<string>|null $predictionIds = null, int $first = 20, string|null $after = null)
 * @method static Prediction                  createPrediction(CreatePredictionRequest $request)
 * @method static Prediction                  endPrediction(string $broadcasterId, string $predictionId, string $status, string|null $winningOutcomeId = null)
 *
 * ── Raids, Hype Train & Whispers (HasRaidMethods) ────────────────────────────
 * @method static Raid                    startRaid(string $fromBroadcasterId, string $toBroadcasterId)
 * @method static void                    cancelRaid(string $broadcasterId)
 * @method static void                    sendWhisper(string $fromUserId, string $toUserId, string $message)
 * @method static HypeTrainStatus            getHypeTrainStatus(string $broadcasterId)
 *
 * ── Streams, Clips & Videos (HasStreamMethods) ────────────────────────────────
 * @method static StreamKey                       getStreamKey(string $broadcasterId)
 * @method static PaginatedResult<Stream>         getStreams(string|array<string>|null $userIds = null, string|array<string>|null $gameIds = null, string|array<string>|null $languages = null, int $first = 20, string|null $after = null)
 * @method static PaginatedResult<Stream>         getFollowedStreams(string $userId, int $first = 20, string|null $after = null)
 * @method static ClipEdit                        createClip(string $broadcasterId, string|null $title = null, float|null $duration = null)
 * @method static ClipEdit                        createClipFromVod(string $editorId, string $broadcasterId, string $vodId, int $vodOffset, string $title, float|null $duration = null)
 * @method static PaginatedResult<Clip>           getClips(string $broadcasterId, string|array<string>|null $clipIds = null, int $first = 20, string|null $after = null, string|null $startedAt = null, string|null $endedAt = null)
 * @method static DataCollection<int, ClipDownload> getClipsDownloads(string $editorId, string $broadcasterId, string|array<string> $clipIds)
 * @method static StreamMarker                    createStreamMarker(string $userId, string|null $description = null)
 * @method static PaginatedResult<StreamMarkerGroup> getStreamMarkers(string $userId, string|null $videoId = null, int $first = 20, string|null $after = null)
 * @method static PaginatedResult<Video>          getVideos(string|null $userId = null, string|null $gameId = null, string|array<string>|null $videoIds = null, string $type = 'all', int $first = 20, string|null $after = null)
 * @method static array<string>                   deleteVideo(string|array<string> $videoIds)
 *
 * ── Teams (HasTeamsMethods) ───────────────────────────────────────────────────
 * @method static DataCollection<int, Team> getChannelTeams(string $broadcasterId)
 * @method static Team                      getTeams(string|null $name = null, string|null $id = null)
 *
 * ── Extensions (HasExtensionsMethods) ────────────────────────────────────────
 * @method static array getExtensionConfigurationSegment(string $extensionId, string $segment, string|null $broadcasterId = null)
 * @method static void  setExtensionConfigurationSegment(string $extensionId, string $segment, string|null $broadcasterId = null, string|null $content = null, string|null $version = null)
 * @method static void  setExtensionRequiredConfiguration(string $broadcasterId, string $extensionId, string $extensionVersion, string $configurationVersion)
 * @method static void  sendExtensionPubSubMessage(string $broadcasterId, string $extensionId, string $message, array<string> $targets = ['broadcast'])
 * @method static array getExtensionLiveChannels(string $extensionId, int $first = 20, string|null $after = null)
 * @method static array getExtensionSecrets(string $extensionId)
 * @method static array createExtensionSecret(string $extensionId, int $delay = 300)
 * @method static void  sendExtensionChatMessage(string $broadcasterId, string $extensionId, string $extensionVersion, string $text)
 * @method static array getExtension(string $extensionId, string|null $extensionVersion = null)
 * @method static array getReleasedExtension(string $extensionId, string|null $extensionVersion = null)
 * @method static array getExtensionBitsProducts(string $extensionClientId, bool $shouldIncludeAll = false)
 * @method static array updateExtensionBitsProduct(string $extensionClientId, array $data)
 *
 * ── Tags (HasTagsMethods) — DEPRECATED ────────────────────────────────────────
 * @method static array getAllStreamTags(string|null $tagId = null, int $first = 20, string|null $after = null)
 * @method static array getStreamTags(string $broadcasterId)
 *
 * ── Users, Follows & Subscriptions (HasUserMethods) ──────────────────────────
 * @method static User|null                      getAuthenticatedUser()
 * @method static DataCollection<int, User>      getUsers(string|array<string>|null $ids = null, string|array<string>|null $logins = null)
 * @method static User                           updateUser(string|null $description = null)
 * @method static PaginatedResult<BlockedUser>   getUserBlocks(string $broadcasterId, int $first = 20, string|null $after = null)
 * @method static void                           blockUser(string $targetUserId, string|null $reason = null)
 * @method static void                           unblockUser(string $targetUserId)
 * @method static PaginatedResult<FollowedChannel> getFollowedChannels(string $userId, string|null $broadcasterId = null, int $first = 20, string|null $after = null)
 * @method static PaginatedResult<Follower>      getChannelFollowers(string $broadcasterId, string|null $userId = null, int $first = 20, string|null $after = null)
 * @method static PaginatedResult<Subscription>  getSubscriptions(string $broadcasterId, string|null $userId = null, int $first = 20, string|null $after = null)
 * @method static SubscriptionCheck              checkUserSubscription(string $broadcasterId, string $userId)
 * @method static array                          getUserExtensions()
 * @method static array                          getUserActiveExtensions(string|null $userId = null)
 * @method static array                          updateUserExtensions(array $data)
 * @method static DataCollection<int, UserAuthorization> getAuthorizationByUser(string|array $userIds)
 */
class Twitch extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @codeCoverageIgnore
     */
    protected static function getFacadeAccessor(): string
    {
        return 'twitch';
    }
}
