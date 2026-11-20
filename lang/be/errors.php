<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Токен доступу Twitch памылковы або скончыўся.',
    'missing_scope'         => 'У токена доступу Twitch не хапае дазволу (scope): :scope.',
    'app_token_required'    => 'Гэты канцавы пункт Twitch прымае толькі токен праграмы.',
    'user_mismatch'         => 'Карыстальнік не з\'яўляецца ўладальнікам токена доступу.',
    'client_mismatch'       => 'Ідэнтыфікатар кліента Twitch не той, што стварыў рэсурс або токен.',
    'no_organization'       => 'Праграма Twitch не звязана з арганізацыяй.',
    'multiple_filters'      => 'Twitch прымае толькі адзін фільтр за раз.',
    'malformed_parameter'   => 'Параметр «:parameter» сфарміраваны няправільна.',
    'bad_identifiers'       => 'Адзін або некалькі ідэнтыфікатараў Twitch (ID, лагіны) няправільныя.',
    'invalid_code'          => 'Код аўтарызацыі Twitch памылковы або скончыўся.',
    'invalid_refresh_token' => 'Токен абнаўлення Twitch памылковы: карыстальніку трэба ўвайсці зноў.',
    'bad_request'           => 'Twitch адхіліў запыт.',
    'unauthorized'          => 'Twitch адхіліў уліковыя даныя.',
    'forbidden'             => 'Гэта дзеянне не дазволена для гэтага ўліковага запісу або гэтай праграмы.',
    'not_found'             => 'Twitch нічога не знайшоў па гэтым запыце.',
    'conflict'              => 'Запыт канфліктуе з бягучым станам на Twitch.',
    'gone'                  => 'Гэтая функцыя Twitch больш недаступная.',
    'unprocessable'         => 'Twitch не здолеў апрацаваць запыт.',
    'rate_limited'          => 'Twitch атрымаў занадта шмат запытаў. Паспрабуйце пазней.',
    'server_error'          => 'У Twitch узнікла праблема. Паспрабуйце пазней.',
    'network'               => 'Не ўдалося звязацца з Twitch.',
    'error'                 => 'Twitch адказаў памылкай.',
];
