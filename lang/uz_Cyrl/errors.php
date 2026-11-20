<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch кириш токени яроқсиз ёки муддати тугаган.',
    'missing_scope'         => 'Twitch кириш токенида рухсат (scope) йўқ: :scope.',
    'app_token_required'    => 'Бу Twitch якуний нуқтаси фақат илова кириш токенини қабул қилади.',
    'user_mismatch'         => 'Фойдаланувчи кириш токенининг эгаси эмас.',
    'client_mismatch'       => 'Twitch мижоз ID си ресурс ёки токенни яратган ID эмас.',
    'no_organization'       => 'Twitch иловаси ташкилотга боғланмаган.',
    'multiple_filters'      => 'Twitch бир вақтда фақат битта филтрни қабул қилади.',
    'malformed_parameter'   => '«:parameter» параметри нотўғри тузилган.',
    'bad_identifiers'       => 'Twitch идентификаторларидан бири ёки бир нечаси (ID, логинлар) яроқсиз.',
    'invalid_code'          => 'Twitch авторизация коди яроқсиз ёки муддати тугаган.',
    'invalid_refresh_token' => 'Twitch янгилаш токени яроқсиз: фойдаланувчи қайта киришi керак.',
    'bad_request'           => 'Twitch сўровни рад этди.',
    'unauthorized'          => 'Twitch маълумотларни рад этди.',
    'forbidden'             => 'Бу амал ушбу ҳисоб ёки илова учун рухсат этилмаган.',
    'not_found'             => 'Twitch бу сўров бўйича ҳеч нарса топмади.',
    'conflict'              => 'Сўров Twitch даги жорий ҳолат билан зид.',
    'gone'                  => 'Twitch нинг бу функцияси энди мавжуд эмас.',
    'unprocessable'         => 'Twitch сўровни қайта ишлай олмади.',
    'rate_limited'          => 'Twitch жуда кўп сўров олди. Кейинроқ қайта уриниб кўринг.',
    'server_error'          => 'Twitch да муаммо бор. Кейинроқ қайта уриниб кўринг.',
    'network'               => 'Twitch билан боғланиб бўлмади.',
    'error'                 => 'Twitch хато билан жавоб берди.',
];
