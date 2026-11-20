<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Нишони дастрасии Twitch беэътибор аст ё муҳлаташ гузаштааст.',
    'missing_scope'         => 'Ба нишони дастрасии Twitch иҷозат (scope) намерасад: :scope.',
    'app_token_required'    => 'Ин нуқтаи ниҳоии Twitch танҳо нишони дастрасии барномаро қабул мекунад.',
    'user_mismatch'         => 'Корбар соҳиби нишони дастрасӣ нест.',
    'client_mismatch'       => 'ID-и муштарии Twitch ҳамонест, ки манбаъ ё нишонро наофаридааст.',
    'no_organization'       => 'Барномаи Twitch ба ташкилот пайваст нест.',
    'multiple_filters'      => 'Twitch дар як вақт танҳо як филтрро қабул мекунад.',
    'malformed_parameter'   => 'Параметри «:parameter» нодуруст сохта шудааст.',
    'bad_identifiers'       => 'Як ё якчанд шиносаи Twitch (ID, номи вуруд) беэътибор аст.',
    'invalid_code'          => 'Рамзи иҷозати Twitch беэътибор аст ё муҳлаташ гузаштааст.',
    'invalid_refresh_token' => 'Нишони навсозии Twitch беэътибор аст: корбар бояд дубора ворид шавад.',
    'bad_request'           => 'Twitch дархостро рад кард.',
    'unauthorized'          => 'Twitch маълумоти воридшавиро рад кард.',
    'forbidden'             => 'Ин амал барои ин ҳисоб ё барнома иҷозат нест.',
    'not_found'             => 'Twitch барои ин дархост чизе наёфт.',
    'conflict'              => 'Дархост бо ҳолати ҷории Twitch мухолиф аст.',
    'gone'                  => 'Ин имкони Twitch дигар дастрас нест.',
    'unprocessable'         => 'Twitch натавонист дархостро коркард кунад.',
    'rate_limited'          => 'Twitch дархостҳои хеле зиёд гирифт. Баъдтар дубора кӯшиш кунед.',
    'server_error'          => 'Twitch мушкилӣ дорад. Баъдтар дубора кӯшиш кунед.',
    'network'               => 'Бо Twitch алоқа барқарор нашуд.',
    'error'                 => 'Twitch бо хато ҷавоб дод.',
];
