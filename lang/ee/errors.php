<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch ƒe nuxɔxɔ token mele nyuie o alo wòtsi.',
    'missing_scope'         => 'Twitch ƒe nuxɔxɔ token ƒe mɔɖeɖe (scope) mele eŋu o: :scope.',
    'app_token_required'    => 'Twitch endpoint sia xɔa app nuxɔxɔ token ɖeka ko.',
    'user_mismatch'         => 'Zãla la menye nuxɔxɔ token la ƒe ŋutɔ o.',
    'client_mismatch'       => 'Twitch client ID menye eya si wɔ nɔnɔmetata alo token la o.',
    'no_organization'       => 'Twitch app la mebla ɖe habɔbɔ aɖe ŋu o.',
    'multiple_filters'      => 'Twitch xɔa filter ɖeka ko ɖe edziɖeɖi ɖeka.',
    'malformed_parameter'   => 'Parameter ":parameter" mele nyuie o.',
    'bad_identifiers'       => 'Twitch dzesidzesi (ID, login) ɖeka alo geɖe mele nyuie o.',
    'invalid_code'          => 'Twitch ƒe mɔɖeɖekoodu mele nyuie o alo wòtsi.',
    'invalid_refresh_token' => 'Twitch ƒe yeyetoken mele nyuie o: ele be zãla la nadze eme gbɔ.',
    'bad_request'           => 'Twitch gbe biabia la.',
    'unauthorized'          => 'Twitch gbe nyatakaka siwo wotsɔ de eme la.',
    'forbidden'             => 'Womeɖe mɔ be woawɔ dɔ sia na akɔnta alo app sia o.',
    'not_found'             => 'Twitch mekpɔ naneke na biabia sia o.',
    'conflict'              => 'Biabia la dze abe alesi nɔ Twitch dzi fifia ene o.',
    'gone'                  => 'Twitch ƒe nɔnɔme sia meli azɔ o.',
    'unprocessable'         => 'Twitch mete ŋu wɔ biabia la o.',
    'rate_limited'          => 'Twitch xɔ biabia geɖe akpa. Gbugbɔ te kpɔ emegbe.',
    'server_error'          => 'Nɔnɔme aɖe le Twitch ŋu. Gbugbɔ te kpɔ emegbe.',
    'network'               => 'Womete ŋu ɖo Twitch gbɔ o.',
    'error'                 => 'Twitch ɖo eŋu kple vodada.',
];
