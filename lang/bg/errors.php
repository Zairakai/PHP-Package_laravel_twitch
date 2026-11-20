<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Токенът за достъп до Twitch е невалиден или е изтекъл.',
    'missing_scope'         => 'На токена за достъп до Twitch липсва разрешение (scope): :scope.',
    'app_token_required'    => 'Тази крайна точка на Twitch приема само токен на приложение.',
    'user_mismatch'         => 'Потребителят не е собственик на токена за достъп.',
    'client_mismatch'       => 'Клиентският ID на Twitch не е този, който е създал ресурса или токена.',
    'no_organization'       => 'Приложението на Twitch не е свързано с организация.',
    'multiple_filters'      => 'Twitch приема само един филтър наведнъж.',
    'malformed_parameter'   => 'Параметърът „:parameter“ е зададен неправилно.',
    'bad_identifiers'       => 'Един или повече идентификатори на Twitch (ID, потребителски имена) са невалидни.',
    'invalid_code'          => 'Кодът за оторизация на Twitch е невалиден или е изтекъл.',
    'invalid_refresh_token' => 'Токенът за подновяване на Twitch е невалиден: потребителят трябва да влезе отново.',
    'bad_request'           => 'Twitch отхвърли заявката.',
    'unauthorized'          => 'Twitch отхвърли данните за вход.',
    'forbidden'             => 'Това действие не е разрешено за този акаунт или това приложение.',
    'not_found'             => 'Twitch не намери нищо за тази заявка.',
    'conflict'              => 'Заявката е в конфликт с текущото състояние в Twitch.',
    'gone'                  => 'Тази функция на Twitch вече не е налична.',
    'unprocessable'         => 'Twitch не можа да обработи заявката.',
    'rate_limited'          => 'Twitch получи твърде много заявки. Опитайте отново по-късно.',
    'server_error'          => 'Twitch има проблем. Опитайте отново по-късно.',
    'network'               => 'Връзката с Twitch не можа да бъде установена.',
    'error'                 => 'Twitch отговори с грешка.',
];
