<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Tokeni ya ufikiaji ya Twitch si halali au muda wake umeisha.',
    'missing_scope'         => 'Tokeni ya ufikiaji ya Twitch haina ruhusa (scope): :scope.',
    'app_token_required'    => 'Kiishio hiki cha Twitch kinakubali tokeni ya ufikiaji ya programu pekee.',
    'user_mismatch'         => 'Mtumiaji si mmiliki wa tokeni ya ufikiaji.',
    'client_mismatch'       => 'Kitambulisho cha mteja cha Twitch si kile kilichounda rasilimali au tokeni.',
    'no_organization'       => 'Programu ya Twitch haijaunganishwa na shirika.',
    'multiple_filters'      => 'Twitch inakubali kichujio kimoja tu kwa wakati mmoja.',
    'malformed_parameter'   => 'Kigezo ":parameter" hakijaundwa ipasavyo.',
    'bad_identifiers'       => 'Kitambulisho kimoja au zaidi vya Twitch (ID, majina ya kuingia) si halali.',
    'invalid_code'          => 'Msimbo wa uidhinishaji wa Twitch si halali au muda wake umeisha.',
    'invalid_refresh_token' => 'Tokeni ya kusasisha ya Twitch si halali: mtumiaji lazima aingie tena.',
    'bad_request'           => 'Twitch imekataa ombi.',
    'unauthorized'          => 'Twitch imekataa stakabadhi.',
    'forbidden'             => 'Kitendo hiki hakiruhusiwi kwa akaunti au programu hii.',
    'not_found'             => 'Twitch haikupata chochote kwa ombi hili.',
    'conflict'              => 'Ombi linakinzana na hali ya sasa kwenye Twitch.',
    'gone'                  => 'Kipengele hiki cha Twitch hakipatikani tena.',
    'unprocessable'         => 'Twitch haikuweza kuchakata ombi.',
    'rate_limited'          => 'Twitch imepokea maombi mengi mno. Jaribu tena baadaye.',
    'server_error'          => 'Twitch ina tatizo. Jaribu tena baadaye.',
    'network'               => 'Twitch haikuweza kufikiwa.',
    'error'                 => 'Twitch imejibu kwa hitilafu.',
];
