<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Twitch Application Credentials
    |--------------------------------------------------------------------------
    |
    | These are your Twitch application credentials. You can get them from
    | your Twitch Developer Console at https://dev.twitch.tv/console/apps
    |
    */
    'client_id'     => env('TWITCH_CLIENT_ID'),
    'client_secret' => env('TWITCH_CLIENT_SECRET'),
    'redirect_uri'  => env('TWITCH_REDIRECT_URI', '/auth/twitch/callback'),

    /*
    |--------------------------------------------------------------------------
    | Twitch API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the Twitch API integration
    |
    */
    'api' => [
        'base_url' => 'https://api.twitch.tv/helix/',
        'auth_url' => 'https://id.twitch.tv/oauth2',
        'timeout'  => 30,
        'retry'    => [
            'times' => 3,
            'sleep' => 500,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | OAuth Scopes
    |--------------------------------------------------------------------------
    |
    | Default scopes to request during OAuth flow
    |
    */
    'scopes' => [
        // Identity
        'user:read:email',

        // Chat — required for bot messaging
        'user:write:chat',
        'user:bot',
        'channel:bot',
        'user:manage:chat_color',
        'user:read:emotes',

        // Moderation — required for ban/timeout/warn/mod management
        'moderation:read',
        'moderator:manage:banned_users',
        'moderator:manage:chat_messages',
        'moderator:manage:announcements',
        'moderator:manage:chat_settings',
        'moderator:manage:warnings',
        'moderator:manage:shield_mode',
        'moderator:manage:automod_settings',
        'moderator:manage:blocked_terms',
        'moderator:manage:shoutouts',
        'moderator:manage:unban_requests',
        'moderator:manage:suspicious_users',
        'moderator:read:chatters',
        'moderator:read:followers',
        'moderator:read:unban_requests',
        'moderator:read:suspicious_users',
        'moderator:read:guest_star',
        'moderator:manage:guest_star',
        'user:read:moderated_channels',

        // Channel management
        'channel:manage:broadcast',
        'channel:manage:schedule',
        'channel:read:editors',
        'channel:manage:moderators',
        'channel:manage:vips',
        'channel:read:vips',

        // Channel Points
        'channel:read:redemptions',
        'channel:manage:redemptions',

        // Ads
        'channel:read:ads',
        'channel:manage:ads',
        'channel:edit:commercial',

        // Polls & Predictions
        'channel:read:polls',
        'channel:manage:polls',
        'channel:read:predictions',
        'channel:manage:predictions',

        // Subscriptions & Bits
        'channel:read:subscriptions',
        'bits:read',

        // Goals
        'channel:read:goals',

        // Charity
        'channel:read:charity',

        // Guest Star
        'channel:read:guest_star',
        'channel:manage:guest_star',

        // Raids, Hype Train, Clips
        'channel:manage:raids',
        'channel:read:hype_train',
        'clips:edit',

        // Follows
        'user:read:follows',

        // Whispers
        'user:manage:whispers',

        // Users & Extensions
        'user:edit',
        'user:read:broadcast',
        'user:edit:broadcast',
        'user:read:blocked_users',
        'user:manage:blocked_users',

        // Analytics
        'analytics:read:extensions',
        'analytics:read:games',

        // Stream key (privileged)
        'channel:read:stream_key',
    ],

    /*
    |--------------------------------------------------------------------------
    | EventSub Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Twitch EventSub webhooks
    |
    */
    'eventsub' => [
        'webhook_callback_url' => env('TWITCH_WEBHOOK_URL'),
        'webhook_secret'       => env('TWITCH_WEBHOOK_SECRET'),
        'enabled_events'       => [
            'channel.update',
            'channel.follow',
            'channel.subscribe',
            'channel.chat.message',
            'channel.subscription.gift',
            'channel.subscription.message',
            'channel.cheer',
            'channel.raid',
            'channel.subscription.end',
            'channel.ban',
            'channel.unban',
            'channel.moderator.add',
            'channel.moderator.remove',
            'channel.vip.add',
            'channel.vip.remove',
            'channel.channel_points_custom_reward.add',
            'channel.channel_points_custom_reward_redemption.add',
            'channel.channel_points_custom_reward_redemption.update',
            'channel.poll.begin',
            'channel.poll.progress',
            'channel.poll.end',
            'channel.prediction.begin',
            'channel.prediction.progress',
            'channel.prediction.lock',
            'channel.prediction.end',
            'channel.hype_train.begin',
            'channel.hype_train.progress',
            'channel.hype_train.end',
            'channel.goal.begin',
            'channel.goal.progress',
            'channel.goal.end',
            'channel.shoutout.create',
            'channel.shoutout.receive',
            'stream.online',
            'stream.offline',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Badge System Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the custom badge system
    |
    */
    'badges' => [
        'enabled'            => env('TWITCH_BADGES_ENABLED', true),
        'cache_ttl'          => env('TWITCH_BADGES_CACHE_TTL', 3600), // 1 hour
        'custom_badges_path' => storage_path('app/twitch/badges'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for database storage
    |
    */
    'database' => [
        'connection'   => env('TWITCH_DB_CONNECTION', config('database.default')),
        'table_prefix' => 'twitch_',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for caching API responses
    |
    */
    'cache' => [
        'enabled' => env('TWITCH_CACHE_ENABLED', true),
        'ttl'     => [
            'user'          => 3600,  // 1 hour
            'stream'        => 300,   // 5 minutes
            'game'          => 86400, // 24 hours
            'badges'        => 3600,  // 1 hour
            'channel'       => 300,   // 5 minutes
            'top_games'     => 600,   // 10 minutes
            'cheermotes'    => 86400, // 24 hours
            'emotes'        => 3600,  // 1 hour
            'global_emotes' => 86400, // 24 hours
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Configuration for API rate limiting
    |
    */
    'rate_limit' => [
        'enabled'             => true,
        'requests_per_minute' => 800, // Twitch API limit
        'burst_limit'         => 120,
    ],
];
