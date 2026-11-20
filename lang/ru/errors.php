<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Токен доступа Twitch недействителен или истёк.',
    'missing_scope'         => 'У токена доступа Twitch не хватает разрешения (scope): :scope.',
    'app_token_required'    => 'Эта конечная точка Twitch принимает только токен приложения.',
    'user_mismatch'         => 'Пользователь не является владельцем токена доступа.',
    'client_mismatch'       => 'Идентификатор клиента Twitch не совпадает с тем, который создал ресурс или токен.',
    'no_organization'       => 'Приложение Twitch не привязано к организации.',
    'multiple_filters'      => 'Twitch принимает только один фильтр за раз.',
    'malformed_parameter'   => 'Параметр «:parameter» сформирован неверно.',
    'bad_identifiers'       => 'Один или несколько идентификаторов Twitch (ID, логины) недействительны.',
    'invalid_code'          => 'Код авторизации Twitch недействителен или истёк.',
    'invalid_refresh_token' => 'Токен обновления Twitch недействителен: пользователю нужно войти снова.',
    'bad_request'           => 'Twitch отклонил запрос.',
    'unauthorized'          => 'Twitch отклонил учётные данные.',
    'forbidden'             => 'Это действие не разрешено для этой учётной записи или этого приложения.',
    'not_found'             => 'Twitch ничего не нашёл по этому запросу.',
    'conflict'              => 'Запрос конфликтует с текущим состоянием на Twitch.',
    'gone'                  => 'Эта функция Twitch больше недоступна.',
    'unprocessable'         => 'Twitch не смог обработать запрос.',
    'rate_limited'          => 'Twitch получил слишком много запросов. Повторите попытку позже.',
    'server_error'          => 'У Twitch возникла проблема. Повторите попытку позже.',
    'network'               => 'Не удалось связаться с Twitch.',
    'error'                 => 'Twitch ответил ошибкой.',
];
