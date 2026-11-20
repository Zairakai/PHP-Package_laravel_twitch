<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Àmì àyẹ̀wò ìwọlé Twitch kò wúlò tàbí ó ti parí.',
    'missing_scope'         => 'Àmì ìwọlé Twitch kò ní àṣẹ (scope): :scope.',
    'app_token_required'    => 'Ibùdó ìparí Twitch yìí gba àmì ìwọlé ohun èlò nìkan.',
    'user_mismatch'         => 'Olùmúlò kì í ṣe olónìí àmì ìwọlé náà.',
    'client_mismatch'       => 'ID oníbàárà Twitch kì í ṣe èyí tó ṣẹ̀dá ohun àmúlò tàbí àmì náà.',
    'no_organization'       => 'A kò so ohun èlò Twitch mọ́ àjọ kan.',
    'multiple_filters'      => 'Twitch gba àlẹ̀mọ́ kan ṣoṣo ní ìgbà kan.',
    'malformed_parameter'   => 'Paramita ":parameter" kò ṣe dáradára.',
    'bad_identifiers'       => 'Ìdánimọ̀ Twitch kan tàbí jù bẹ́ẹ̀ lọ (ID, wọlé) kò wúlò.',
    'invalid_code'          => 'Kóòdù àṣẹ Twitch kò wúlò tàbí ó ti parí.',
    'invalid_refresh_token' => 'Àmì ìtúnṣe Twitch kò wúlò: olùmúlò gbọ́dọ̀ wọlé lẹ́ẹ̀kan sí i.',
    'bad_request'           => 'Twitch kọ ìbéèrè náà.',
    'unauthorized'          => 'Twitch kọ àwọn ẹ̀rí ìwọlé.',
    'forbidden'             => 'A kò gbà iṣẹ́ yìí fún àkọọ́lẹ̀ tàbí ohun èlò yìí.',
    'not_found'             => 'Twitch kò rí nǹkan kan fún ìbéèrè yìí.',
    'conflict'              => 'Ìbéèrè náà ń takò ipò tó wà báyìí lórí Twitch.',
    'gone'                  => 'Ẹ̀yà Twitch yìí kò sí mọ́.',
    'unprocessable'         => 'Twitch kò lè ṣe ìbéèrè náà.',
    'rate_limited'          => 'Twitch gba ìbéèrè púpọ̀ jù. Gbìyànjú lẹ́ẹ̀kan sí i lẹ́yìn náà.',
    'server_error'          => 'Twitch ní ìṣòro. Gbìyànjú lẹ́ẹ̀kan sí i lẹ́yìn náà.',
    'network'               => 'A kò lè dé Twitch.',
    'error'                 => 'Twitch dáhùn pẹ̀lú àṣìṣe.',
];
