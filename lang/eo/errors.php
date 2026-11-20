<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'La alira ĵetono de Twitch estas nevalida aŭ eksvalidiĝis.',
    'missing_scope'         => 'Al la alira ĵetono de Twitch mankas permeso (scope): :scope.',
    'app_token_required'    => 'Ĉi tiu finpunkto de Twitch akceptas nur aplikaĵan aliran ĵetonon.',
    'user_mismatch'         => 'La uzanto ne estas la posedanto de la alira ĵetono.',
    'client_mismatch'       => 'La klienta ID de Twitch ne estas tiu, kiu kreis la rimedon aŭ la ĵetonon.',
    'no_organization'       => 'La aplikaĵo de Twitch ne estas ligita al organizo.',
    'multiple_filters'      => 'Twitch akceptas nur unu filtrilon samtempe.',
    'malformed_parameter'   => 'La parametro «:parameter» estas malĝuste formita.',
    'bad_identifiers'       => 'Unu aŭ pluraj identigiloj de Twitch (ID, salutnomoj) estas nevalidaj.',
    'invalid_code'          => 'La rajtiga kodo de Twitch estas nevalida aŭ eksvalidiĝis.',
    'invalid_refresh_token' => 'La reŝarĝa ĵetono de Twitch estas nevalida: la uzanto devas denove ensaluti.',
    'bad_request'           => 'Twitch rifuzis la peton.',
    'unauthorized'          => 'Twitch rifuzis la akreditaĵojn.',
    'forbidden'             => 'Ĉi tiu ago ne estas permesita por ĉi tiu konto aŭ aplikaĵo.',
    'not_found'             => 'Twitch trovis nenion por ĉi tiu peto.',
    'conflict'              => 'La peto konfliktas kun la nuna stato ĉe Twitch.',
    'gone'                  => 'Ĉi tiu funkcio de Twitch ne plu disponeblas.',
    'unprocessable'         => 'Twitch ne povis prilabori la peton.',
    'rate_limited'          => 'Twitch ricevis tro multajn petojn. Reprovu poste.',
    'server_error'          => 'Twitch havas problemon. Reprovu poste.',
    'network'               => 'Ne eblis kontakti Twitch.',
    'error'                 => 'Twitch respondis per eraro.',
];
