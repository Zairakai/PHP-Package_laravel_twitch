<?php

return [
    /*
    | Twitch application credentials, from https://dev.twitch.tv/console/apps
    | redirect_uri: the OAuth callback. The default is the route of the package, made absolute with the URL of the
    | application; register that URL in the Twitch console.
    */
    'client_id'     => env('TWITCH_CLIENT_ID'),
    'client_secret' => env('TWITCH_CLIENT_SECRET'),
    'redirect_uri'  => env('TWITCH_REDIRECT_URI', '/twitch/auth/callback'),

    /*
    | Where the callback goes once the user is connected (or refused): a route name, or a URL (a value that starts
    | with `/` or `http`).
    */
    'oauth' => [
        'redirect_to' => env('TWITCH_OAUTH_REDIRECT_TO', 'home'),
    ],

    /*
    | Twitch API. retry: how many times a 429 is retried, and the wait in milliseconds when Twitch gives no
    | Ratelimit-Reset.
    */
    'api' => [
        'base_url' => 'https://api.twitch.tv/helix/',
        'auth_url' => 'https://id.twitch.tv/oauth2/',
        'timeout'  => 30,
        'retry'    => [
            'times' => 3,
            'sleep' => 500,
        ],
    ],

    /*
    | Scopes asked by default during the OAuth flow: the ones of a moderation and chat bot. The moderator:read:*
    | scopes are covered by the moderator:manage:* listed (Twitch accepts either).
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
        'user:read:subscriptions',

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
        'moderator:read:chat_messages',
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

        // Clips and videos
        'channel:manage:clips',
        'editor:manage:clips',
        'channel:manage:videos',

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
    | EventSub. max_message_age: seconds after which a signed notification is refused as a possible replay (Twitch
    | suggests 10 minutes). dedupe_ttl: seconds during which a message ID is remembered, to ignore the copies Twitch
    | can send (it delivers at least once). null or 0 turns either check off.
    */
    'eventsub' => [
        'webhook_callback_url' => env('TWITCH_WEBHOOK_URL'),
        'webhook_secret'       => env('TWITCH_WEBHOOK_SECRET'),
        'max_message_age'      => 600,
        'dedupe_ttl'           => 3600,
    ],

    /*
    | Custom badges (unlocked by watch time or by subscription volume, created per channel).
    | Not used yet.
    */
    'badges' => [
        'enabled'            => env('TWITCH_BADGES_ENABLED', true),
        'cache_ttl'          => env('TWITCH_BADGES_CACHE_TTL', 3600), // 1 hour
        'custom_badges_path' => storage_path('app/twitch/badges'),
    ],

    /*
    | Storage of the users and their tokens, which can live in another database than the main one. A null connection
    | is the default one. load_migrations: false when the migration is published in the application
    | (php artisan vendor:publish --tag=twitch-migrations).
    */
    'database' => [
        'connection'      => env('TWITCH_DB_CONNECTION', config('database.default')),
        'table_prefix'    => 'twitch_',
        'load_migrations' => env('TWITCH_LOAD_MIGRATIONS', true),
    ],

    /*
    | Cache of the public answers, in seconds. enabled=false turns every cache off.
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
    | Rate limit of the calls to Twitch: a token bucket kept in the cache, shared by every process and per client ID.
    | It holds burst_limit calls and is refilled at requests_per_minute per minute; a call waits when it is empty.
    | Twitch gives each app 800 points per minute.
    */
    'rate_limit' => [
        'enabled'             => true,
        'requests_per_minute' => 800, // Twitch API limit
        'burst_limit'         => 120,
    ],
];
