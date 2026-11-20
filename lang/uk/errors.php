<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Токен доступу Twitch недійсний або термін його дії минув.',
    'missing_scope'         => 'У токена доступу Twitch бракує дозволу (scope): :scope.',
    'app_token_required'    => 'Ця кінцева точка Twitch приймає лише токен застосунку.',
    'user_mismatch'         => 'Користувач не є власником токена доступу.',
    'client_mismatch'       => 'Ідентифікатор клієнта Twitch не збігається з тим, що створив ресурс або токен.',
    'no_organization'       => 'Застосунок Twitch не прив\'язаний до організації.',
    'multiple_filters'      => 'Twitch приймає лише один фільтр за раз.',
    'malformed_parameter'   => 'Параметр «:parameter» сформовано неправильно.',
    'bad_identifiers'       => 'Один або кілька ідентифікаторів Twitch (ID, логіни) недійсні.',
    'invalid_code'          => 'Код авторизації Twitch недійсний або термін його дії минув.',
    'invalid_refresh_token' => 'Токен оновлення Twitch недійсний: користувачеві потрібно увійти знову.',
    'bad_request'           => 'Twitch відхилив запит.',
    'unauthorized'          => 'Twitch відхилив облікові дані.',
    'forbidden'             => 'Ця дія не дозволена для цього облікового запису або цього застосунку.',
    'not_found'             => 'Twitch нічого не знайшов за цим запитом.',
    'conflict'              => 'Запит суперечить поточному стану на Twitch.',
    'gone'                  => 'Ця функція Twitch більше недоступна.',
    'unprocessable'         => 'Twitch не зміг обробити запит.',
    'rate_limited'          => 'Twitch отримав забагато запитів. Спробуйте пізніше.',
    'server_error'          => 'У Twitch виникла проблема. Спробуйте пізніше.',
    'network'               => 'Не вдалося зв\'язатися з Twitch.',
    'error'                 => 'Twitch відповів помилкою.',
];
