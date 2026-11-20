<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Shenja e hyrjes së Twitch është e pavlefshme ose ka skaduar.',
    'missing_scope'         => 'Shenjës së hyrjes së Twitch i mungon një leje (scope): :scope.',
    'app_token_required'    => 'Ky pikë-fund i Twitch pranon vetëm një shenjë hyrjeje aplikacioni.',
    'user_mismatch'         => 'Përdoruesi nuk është pronari i shenjës së hyrjes.',
    'client_mismatch'       => 'ID-ja e klientit të Twitch nuk është ajo që krijoi burimin ose shenjën.',
    'no_organization'       => 'Aplikacioni i Twitch nuk është i lidhur me një organizatë.',
    'multiple_filters'      => 'Twitch pranon vetëm një filtër në të njëjtën kohë.',
    'malformed_parameter'   => 'Parametri «:parameter» nuk është formuar saktë.',
    'bad_identifiers'       => 'Një ose më shumë identifikues të Twitch (ID, emra hyrjeje) janë të pavlefshëm.',
    'invalid_code'          => 'Kodi i autorizimit të Twitch është i pavlefshëm ose ka skaduar.',
    'invalid_refresh_token' => 'Shenja e rifreskimit të Twitch është e pavlefshme: përdoruesi duhet të hyjë përsëri.',
    'bad_request'           => 'Twitch e refuzoi kërkesën.',
    'unauthorized'          => 'Twitch refuzoi kredencialet.',
    'forbidden'             => 'Ky veprim nuk lejohet për këtë llogari ose aplikacion.',
    'not_found'             => 'Twitch nuk gjeti asgjë për këtë kërkesë.',
    'conflict'              => 'Kërkesa është në konflikt me gjendjen aktuale në Twitch.',
    'gone'                  => 'Ky funksion i Twitch nuk është më i disponueshëm.',
    'unprocessable'         => 'Twitch nuk mundi ta përpunonte kërkesën.',
    'rate_limited'          => 'Twitch mori shumë kërkesa. Provoni përsëri më vonë.',
    'server_error'          => 'Twitch ka një problem. Provoni përsëri më vonë.',
    'network'               => 'Nuk u arrit të kontaktohej Twitch.',
    'error'                 => 'Twitch u përgjigj me një gabim.',
];
