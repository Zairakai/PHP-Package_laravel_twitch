<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Itoken yokufikelela yeTwitch ayisebenzi okanye iphelelwe lixesha.',
    'missing_scope'         => 'Itoken yokufikelela yeTwitch ilahlekelwe yimvume (scope): :scope.',
    'app_token_required'    => 'Esi siphelo seTwitch samkela kuphela itoken yokufikelela yesicelo.',
    'user_mismatch'         => 'Umsebenzisi akanguye umnini wetoken yokufikelela.',
    'client_mismatch'       => 'I-ID yomthengi weTwitch ayisiyo eyenze isixhobo okanye itoken.',
    'no_organization'       => 'Isicelo seTwitch asiqhagamshelwanga kumbutho.',
    'multiple_filters'      => 'I-Twitch yamkela isihluzi esinye kuphela ngexesha.',
    'malformed_parameter'   => 'Iparameter ":parameter" ayakhiwanga ngokuchanekileyo.',
    'bad_identifiers'       => 'Umchazi omnye okanye ngaphezulu weTwitch (ID, ukungena) awusebenzi.',
    'invalid_code'          => 'Ikhowudi yemvume yeTwitch ayisebenzi okanye iphelelwe lixesha.',
    'invalid_refresh_token' => 'Itoken yokuhlaziya yeTwitch ayisebenzi: umsebenzisi kufuneka angene kwakhona.',
    'bad_request'           => 'I-Twitch ikhatyile isicelo.',
    'unauthorized'          => 'I-Twitch ikhatyile iinkcukacha zokungena.',
    'forbidden'             => 'Esi senzo asiivumelekanga kule akhawunti okanye kesi sicelo.',
    'not_found'             => 'I-Twitch ayifumananga nto kwesi sicelo.',
    'conflict'              => 'Isicelo siphikisana nemeko yangoku kuTwitch.',
    'gone'                  => 'Esi sici seTwitch asisafumaneki.',
    'unprocessable'         => 'I-Twitch ayikwazanga ukusebenza isicelo.',
    'rate_limited'          => 'I-Twitch ifumene izicelo ezininzi kakhulu. Zama kwakhona kamva.',
    'server_error'          => 'I-Twitch inengxaki. Zama kwakhona kamva.',
    'network'               => 'Ayikwazanga ukufikelela kuTwitch.',
    'error'                 => 'I-Twitch iphendule ngempazamo.',
];
