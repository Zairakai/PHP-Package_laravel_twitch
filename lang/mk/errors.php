<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Токенот за пристап на Twitch е невалиден или е истечен.',
    'missing_scope'         => 'На токенот за пристап на Twitch му недостига дозвола (scope): :scope.',
    'app_token_required'    => 'Оваа крајна точка на Twitch прифаќа само токен за пристап на апликација.',
    'user_mismatch'         => 'Корисникот не е сопственик на токенот за пристап.',
    'client_mismatch'       => 'ID-то на клиентот на Twitch не е она што го создало ресурсот или токенот.',
    'no_organization'       => 'Апликацијата на Twitch не е поврзана со организација.',
    'multiple_filters'      => 'Twitch прифаќа само еден филтер одеднаш.',
    'malformed_parameter'   => 'Параметарот „:parameter“ не е правилно формиран.',
    'bad_identifiers'       => 'Еден или повеќе идентификатори на Twitch (ID, кориснички имиња) се невалидни.',
    'invalid_code'          => 'Кодот за авторизација на Twitch е невалиден или е истечен.',
    'invalid_refresh_token' => 'Токенот за освежување на Twitch е невалиден: корисникот мора повторно да се најави.',
    'bad_request'           => 'Twitch го одби барањето.',
    'unauthorized'          => 'Twitch ги одби акредитивите.',
    'forbidden'             => 'Оваа дејство не е дозволено за оваа сметка или апликација.',
    'not_found'             => 'Twitch не најде ништо за ова барање.',
    'conflict'              => 'Барањето е во конфликт со тековната состојба на Twitch.',
    'gone'                  => 'Оваа функција на Twitch повеќе не е достапна.',
    'unprocessable'         => 'Twitch не можеше да го обработи барањето.',
    'rate_limited'          => 'Twitch доби премногу барања. Обидете се повторно подоцна.',
    'server_error'          => 'Twitch има проблем. Обидете се повторно подоцна.',
    'network'               => 'Не можеше да се воспостави врска со Twitch.',
    'error'                 => 'Twitch одговори со грешка.',
];
