<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch керү токены дөрес түгел яки вакыты чыккан.',
    'missing_scope'         => 'Twitch керү токенында рөхсәт (scope) җитми: :scope.',
    'app_token_required'    => 'Бу Twitch ахыргы ноктасы бары тик кушымта токенын кабул итә.',
    'user_mismatch'         => 'Кулланучы керү токенының хуҗасы түгел.',
    'client_mismatch'       => 'Twitch клиент ID ресурсны яки токенны булдырган ID түгел.',
    'no_organization'       => 'Twitch кушымтасы оешмага бәйләнмәгән.',
    'multiple_filters'      => 'Twitch бер үк вакытта бер генә фильтр кабул итә.',
    'malformed_parameter'   => '«:parameter» параметры дөрес төзелмәгән.',
    'bad_identifiers'       => 'Twitch идентификаторларының берсе яки берничәсе (ID, логиннар) дөрес түгел.',
    'invalid_code'          => 'Twitch авторизация коды дөрес түгел яки вакыты чыккан.',
    'invalid_refresh_token' => 'Twitch яңарту токены дөрес түгел: кулланучы кабат керергә тиеш.',
    'bad_request'           => 'Twitch үтенечне кире какты.',
    'unauthorized'          => 'Twitch мәгълүматларны кире какты.',
    'forbidden'             => 'Бу гамәл бу хисап яки кушымта өчен рөхсәт ителмәгән.',
    'not_found'             => 'Twitch бу үтенеч буенча бернәрсә дә тапмады.',
    'conflict'              => 'Үтенеч Twitch-тагы хәзерге хәл белән каршылыклы.',
    'gone'                  => 'Twitch-ның бу функциясе инде булмый.',
    'unprocessable'         => 'Twitch үтенечне эшкәртә алмады.',
    'rate_limited'          => 'Twitch бик күп үтенеч алды. Соңрак кабат карагыз.',
    'server_error'          => 'Twitch-та проблема бар. Соңрак кабат карагыз.',
    'network'               => 'Twitch белән элемтә урнаштырып булмады.',
    'error'                 => 'Twitch хата белән җавап бирде.',
];
