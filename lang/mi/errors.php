<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Kāore te tohu uru Twitch e tika, kua pau rānei te wā.',
    'missing_scope'         => 'Kei te ngaro he whakaaetanga (scope) i te tohu uru Twitch: :scope.',
    'app_token_required'    => 'Ka whakaae noa tēnei pūwāhi mutunga Twitch ki te tohu uru taupānga.',
    'user_mismatch'         => 'Ehara te kaiwhakamahi i te kaipupuri o te tohu uru.',
    'client_mismatch'       => 'Ehara te ID kiritaki Twitch i te mea nāna i hanga te rauemi, te tohu rānei.',
    'no_organization'       => 'Kāore te taupānga Twitch i te hono ki tētahi whakahaere.',
    'multiple_filters'      => 'Kotahi noa te tātari ka whakaae a Twitch i ia wā.',
    'malformed_parameter'   => 'Kāore i tika te hanga o te tawhā ":parameter".',
    'bad_identifiers'       => 'Kāore tētahi, neke atu rānei o ngā tautuhi Twitch (ID, ingoa takiuru) e tika.',
    'invalid_code'          => 'Kāore te waehere whakamanatanga Twitch e tika, kua pau rānei te wā.',
    'invalid_refresh_token' => 'Kāore te tohu whakahou Twitch e tika: me takiuru anō te kaiwhakamahi.',
    'bad_request'           => 'I whakahē a Twitch i te tono.',
    'unauthorized'          => 'I whakahē a Twitch i ngā tohu tuakiri.',
    'forbidden'             => 'Kāore tēnei mahi e whakaaetia mō tēnei kaute, taupānga rānei.',
    'not_found'             => 'Kāore a Twitch i kite i tētahi mea mō tēnei tono.',
    'conflict'              => 'E tākirikiri ana te tono ki te āhua o nāianei i Twitch.',
    'gone'                  => 'Kāore tēnei āhuatanga Twitch e watea ana.',
    'unprocessable'         => 'Kāore a Twitch i taea te tukatuka i te tono.',
    'rate_limited'          => 'He nui rawa ngā tono i riro mai ki a Twitch. Whakamātauria anō i muri.',
    'server_error'          => 'He raruraru kei Twitch. Whakamātauria anō i muri.',
    'network'               => 'Kāore i taea te whakapā atu ki a Twitch.',
    'error'                 => 'I whakahoki a Twitch me te hapa.',
];
