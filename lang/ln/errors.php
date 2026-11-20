<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Token ya kokota ya Twitch ezali malamu te to esilí tango.',
    'missing_scope'         => 'Token ya kokota ya Twitch ezangi ndingisa (scope): :scope.',
    'app_token_required'    => 'Endpoint oyo ya Twitch endimaka kaka token ya kokota ya application.',
    'user_mismatch'         => 'Mosáleli azali nkolo ya token ya kokota te.',
    'client_mismatch'       => 'ID ya kliya ya Twitch ezali oyo esalaki biloko to token te.',
    'no_organization'       => 'Application ya Twitch ekangami na organisation te.',
    'multiple_filters'      => 'Twitch endimaka kaka filtre moko na mbala moko.',
    'malformed_parameter'   => 'Parametre ":parameter" esalemi malamu te.',
    'bad_identifiers'       => 'Bilembo moko to mingi ya Twitch (ID, login) ezali malamu te.',
    'invalid_code'          => 'Code ya ndingisa ya Twitch ezali malamu te to esilí tango.',
    'invalid_refresh_token' => 'Token ya kobongisa ya Twitch ezali malamu te: mosáleli asengeli kokota lisusu.',
    'bad_request'           => 'Twitch ápɛsí tɛ ɛsɛngi.',
    'unauthorized'          => 'Twitch ápɛsí tɛ bilembo ya kokota.',
    'forbidden'             => 'Misala oyo epesami ndingisa te mpo na compte to application oyo.',
    'not_found'             => 'Twitch azwi eloko te mpo na esengo oyo.',
    'conflict'              => 'Esengo ekotisi na mokanda ya sikoyo na Twitch.',
    'gone'                  => 'Likambo oyo ya Twitch ezali lisusu te.',
    'unprocessable'         => 'Twitch akokaki kosala esengo te.',
    'rate_limited'          => 'Twitch azwi esengo mingi mpenza. Meká lisusu na nsima.',
    'server_error'          => 'Twitch azali na mikakatano. Meká lisusu na nsima.',
    'network'               => 'Twitch ekokaki kokómama te.',
    'error'                 => 'Twitch ayanoli na libunga.',
];
