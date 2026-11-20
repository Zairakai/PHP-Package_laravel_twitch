<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Tsy manan-kery ny token fidirana Twitch na tapitra ny fe-potoany.',
    'missing_scope'         => 'Ny token fidirana Twitch dia tsy manana alalana (scope): :scope.',
    'app_token_required'    => 'Ity endpoint Twitch ity dia manaiky ny token fidirana ny application ihany.',
    'user_mismatch'         => 'Tsy tompon\'ny token fidirana ny mpampiasa.',
    'client_mismatch'       => 'Tsy ilay ID mpanjifa Twitch namorona ny loharano na ny token.',
    'no_organization'       => 'Tsy mifandray amin\'ny fikambanana ny application Twitch.',
    'multiple_filters'      => 'Manaiky sivana iray ihany isaky ny indray mandeha ny Twitch.',
    'malformed_parameter'   => 'Diso ny fananganana ny paramètre ":parameter".',
    'bad_identifiers'       => 'Tsy manan-kery ny mpamantatra Twitch iray na maromaro (ID, login).',
    'invalid_code'          => 'Tsy manan-kery ny kaody fahazoan-dalana Twitch na tapitra ny fe-potoany.',
    'invalid_refresh_token' => 'Tsy manan-kery ny token fanavaozana Twitch: tsy maintsy miditra indray ny mpampiasa.',
    'bad_request'           => 'Nolavin\'ny Twitch ny fangatahana.',
    'unauthorized'          => 'Nolavin\'ny Twitch ny fanamarinana.',
    'forbidden'             => 'Tsy avela ity hetsika ity ho an\'ity kaonty na application ity.',
    'not_found'             => 'Tsy nahita na inona na inona ny Twitch ho an\'ity fangatahana ity.',
    'conflict'              => 'Mifanipaka amin\'ny toe-javatra ankehitriny ao amin\'ny Twitch ny fangatahana.',
    'gone'                  => 'Tsy misy intsony ity endri-javatra Twitch ity.',
    'unprocessable'         => 'Tsy nahavita nanodina ny fangatahana ny Twitch.',
    'rate_limited'          => 'Nahazo fangatahana be loatra ny Twitch. Andramo indray rehefa afaka kelikely.',
    'server_error'          => 'Misy olana ny Twitch. Andramo indray rehefa afaka kelikely.',
    'network'               => 'Tsy azo tonga tany amin\'ny Twitch.',
    'error'                 => 'Namaly tamin\'ny hadisoana ny Twitch.',
];
