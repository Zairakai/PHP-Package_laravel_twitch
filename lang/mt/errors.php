<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'It-token tal-aċċess ta\' Twitch mhuwiex validu jew skada.',
    'missing_scope'         => 'It-token tal-aċċess ta\' Twitch jonqos permess (scope): :scope.',
    'app_token_required'    => 'Dan il-punt tat-tmiem ta\' Twitch jaċċetta biss token tal-aċċess ta\' applikazzjoni.',
    'user_mismatch'         => 'L-utent mhuwiex is-sid tat-token tal-aċċess.',
    'client_mismatch'       => 'L-ID tal-klijent ta\' Twitch mhuwiex dak li ħoloq ir-riżorsa jew it-token.',
    'no_organization'       => 'L-applikazzjoni ta\' Twitch mhijiex marbuta ma\' organizzazzjoni.',
    'multiple_filters'      => 'Twitch jaċċetta filtru wieħed biss kull darba.',
    'malformed_parameter'   => 'Il-parametru ":parameter" mhuwiex iffurmat sew.',
    'bad_identifiers'       => 'Identifikatur wieħed jew aktar ta\' Twitch (ID, logins) mhumiex validi.',
    'invalid_code'          => 'Il-kodiċi tal-awtorizzazzjoni ta\' Twitch mhuwiex validu jew skada.',
    'invalid_refresh_token' => 'It-token tal-aġġornament ta\' Twitch mhuwiex validu: l-utent irid jidħol mill-ġdid.',
    'bad_request'           => 'Twitch irrifjuta t-talba.',
    'unauthorized'          => 'Twitch irrifjuta l-kredenzjali.',
    'forbidden'             => 'Din l-azzjoni mhijiex permessa għal dan il-kont jew din l-applikazzjoni.',
    'not_found'             => 'Twitch ma sab xejn għal din it-talba.',
    'conflict'              => 'It-talba hija f\'kunflitt mal-istat attwali fuq Twitch.',
    'gone'                  => 'Din il-karatteristika ta\' Twitch m\'għadhiex disponibbli.',
    'unprocessable'         => 'Twitch ma setax jipproċessa t-talba.',
    'rate_limited'          => 'Twitch irċieva wisq talbiet. Erġa\' pprova aktar tard.',
    'server_error'          => 'Twitch għandu problema. Erġa\' pprova aktar tard.',
    'network'               => 'Ma setax jintlaħaq Twitch.',
    'error'                 => 'Twitch wieġeb b\'żball.',
];
