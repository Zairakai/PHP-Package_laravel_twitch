<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch access token si nnungi oba ekomye.',
    'missing_scope'         => 'Twitch access token tekirimu lukusa (scope): :scope.',
    'app_token_required'    => 'Endpoint eno eya Twitch ekkiriza app access token yokka.',
    'user_mismatch'         => 'Omukozesa si mulyo wa access token.',
    'client_mismatch'       => 'Twitch client ID si eyo eyakola ekintu oba token.',
    'no_organization'       => 'Twitch application tezirinaako akakwate na kitongole.',
    'multiple_filters'      => 'Twitch ekkiriza filter emu yokka omulundi gumu.',
    'malformed_parameter'   => 'Parameter ":parameter" tezimbiddwa bulungi.',
    'bad_identifiers'       => 'Twitch identifier emu oba ezisukka (ID, login) si nnungi.',
    'invalid_code'          => 'Twitch authorization code si nnungi oba ekomye.',
    'invalid_refresh_token' => 'Twitch refresh token si nnungi: omukozesa alina okuyingira nate.',
    'bad_request'           => 'Twitch ekyaliddewo okusaba.',
    'unauthorized'          => 'Twitch ekyaliddewo ebiwandiiko by\'okuyingira.',
    'forbidden'             => 'Omulimu guno tegukkirizibwa ku akawunti oba application eno.',
    'not_found'             => 'Twitch tesanze kantu ku kusaba kuno.',
    'conflict'              => 'Okusaba kukontana n\'embeera eriwo kati ku Twitch.',
    'gone'                  => 'Ekintu kino ekya Twitch tekikyaliwo.',
    'unprocessable'         => 'Twitch tesobodde kukola ku kusaba.',
    'rate_limited'          => 'Twitch efunye okusaba bungi nnyo. Gezaako nate oluvannyuma.',
    'server_error'          => 'Twitch erina obuzibu. Gezaako nate oluvannyuma.',
    'network'               => 'Twitch tesobola kutuukibwako.',
    'error'                 => 'Twitch ewaddemu n\'ensobi.',
];
