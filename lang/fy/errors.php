<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'It Twitch-tagongstoken is ûnjildich of ferrûn.',
    'missing_scope'         => 'It Twitch-tagongstoken mist in tastimming (scope): :scope.',
    'app_token_required'    => 'Dit Twitch-einpunt akseptearret allinnich in app-tagongstoken.',
    'user_mismatch'         => 'De brûker is net de eigener fan it tagongstoken.',
    'client_mismatch'       => 'It Twitch-klient-ID is net dejinge dy\'t de boarne of it token makke hat.',
    'no_organization'       => 'De Twitch-applikaasje is net keppele oan in organisaasje.',
    'multiple_filters'      => 'Twitch akseptearret mar ien filter tagelyk.',
    'malformed_parameter'   => 'De parameter ":parameter" is ferkeard opboud.',
    'bad_identifiers'       => 'Ien of mear Twitch-identifikatoaren (ID\'s, ynlognammen) binne ûnjildich.',
    'invalid_code'          => 'De Twitch-autorisaasjekoade is ûnjildich of ferrûn.',
    'invalid_refresh_token' => 'It Twitch-fernijingstoken is ûnjildich: de brûker moat opnij ynlogge.',
    'bad_request'           => 'Twitch hat it fersyk wegere.',
    'unauthorized'          => 'Twitch hat de ynloggegevens wegere.',
    'forbidden'             => 'Dizze aksje is net tastien foar dit akkount of dizze applikaasje.',
    'not_found'             => 'Twitch hat neat fûn foar dit fersyk.',
    'conflict'              => 'It fersyk is yn striid mei de hjoeddeistige steat op Twitch.',
    'gone'                  => 'Dizze Twitch-funksje is net mear beskikber.',
    'unprocessable'         => 'Twitch koe it fersyk net ferwurkje.',
    'rate_limited'          => 'Twitch hat te folle fersiken krigen. Probearje it letter opnij.',
    'server_error'          => 'Twitch hat in probleem. Probearje it letter opnij.',
    'network'               => 'Twitch koe net berikt wurde.',
    'error'                 => 'Twitch hat mei in flater antwurde.',
];
