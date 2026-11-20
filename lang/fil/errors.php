<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Hindi wasto o nag-expire na ang access token ng Twitch.',
    'missing_scope'         => 'Kulang ng pahintulot (scope) ang access token ng Twitch: :scope.',
    'app_token_required'    => 'Ang Twitch endpoint na ito ay tumatanggap lang ng app access token.',
    'user_mismatch'         => 'Hindi ang user ang may-ari ng access token.',
    'client_mismatch'       => 'Hindi ang Twitch client ID ang lumikha ng resource o ng token.',
    'no_organization'       => 'Hindi nakakonekta ang Twitch application sa isang organisasyon.',
    'multiple_filters'      => 'Isang filter lang ang tinatanggap ng Twitch sa bawat pagkakataon.',
    'malformed_parameter'   => 'Mali ang pagkakabuo ng parameter na ":parameter".',
    'bad_identifiers'       => 'Hindi wasto ang isa o higit pang Twitch identifier (mga ID, login).',
    'invalid_code'          => 'Hindi wasto o nag-expire na ang authorization code ng Twitch.',
    'invalid_refresh_token' => 'Hindi wasto ang refresh token ng Twitch: kailangang mag-login muli ang user.',
    'bad_request'           => 'Tinanggihan ng Twitch ang kahilingan.',
    'unauthorized'          => 'Tinanggihan ng Twitch ang mga kredensyal.',
    'forbidden'             => 'Hindi pinapayagan ang aksyong ito para sa account o application na ito.',
    'not_found'             => 'Walang nakita ang Twitch para sa kahilingang ito.',
    'conflict'              => 'Sumasalungat ang kahilingan sa kasalukuyang estado sa Twitch.',
    'gone'                  => 'Hindi na available ang feature na ito ng Twitch.',
    'unprocessable'         => 'Hindi naproseso ng Twitch ang kahilingan.',
    'rate_limited'          => 'Masyadong maraming kahilingan ang natanggap ng Twitch. Subukang muli mamaya.',
    'server_error'          => 'May problema ang Twitch. Subukang muli mamaya.',
    'network'               => 'Hindi maabot ang Twitch.',
    'error'                 => 'Sumagot ang Twitch ng error.',
];
