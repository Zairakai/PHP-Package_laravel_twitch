<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch приступни токен је неважећи или је истекао.',
    'missing_scope'         => 'Twitch приступном токену недостаје дозвола (scope): :scope.',
    'app_token_required'    => 'Ова Twitch крајња тачка прихвата само токен апликације.',
    'user_mismatch'         => 'Корисник није власник приступног токена.',
    'client_mismatch'       => 'Twitch ID клијента није онај који је креирао ресурс или токен.',
    'no_organization'       => 'Twitch апликација није повезана са организацијом.',
    'multiple_filters'      => 'Twitch прихвата само један филтер истовремено.',
    'malformed_parameter'   => 'Параметар „:parameter“ није исправно формиран.',
    'bad_identifiers'       => 'Један или више Twitch идентификатора (ID-ови, корисничка имена) нису важећи.',
    'invalid_code'          => 'Twitch ауторизациони код је неважећи или је истекао.',
    'invalid_refresh_token' => 'Twitch токен за освежавање је неважећи: корисник мора поново да се пријави.',
    'bad_request'           => 'Twitch је одбио захтев.',
    'unauthorized'          => 'Twitch је одбио акредитиве.',
    'forbidden'             => 'Ова радња није дозвољена за овај налог или апликацију.',
    'not_found'             => 'Twitch није пронашао ништа за овај захтев.',
    'conflict'              => 'Захтев је у сукобу са тренутним стањем на Twitch-у.',
    'gone'                  => 'Ова Twitch функција више није доступна.',
    'unprocessable'         => 'Twitch није могао да обради захтев.',
    'rate_limited'          => 'Twitch је примио превише захтева. Покушајте поново касније.',
    'server_error'          => 'Twitch има проблем. Покушајте поново касније.',
    'network'               => 'Није могуће успоставити везу са Twitch-ом.',
    'error'                 => 'Twitch је одговорио грешком.',
];
