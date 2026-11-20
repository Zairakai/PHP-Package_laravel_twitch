<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch кирүү токени жараксыз же мөөнөтү өткөн.',
    'missing_scope'         => 'Twitch кирүү токенинде уруксат (scope) жок: :scope.',
    'app_token_required'    => 'Бул Twitch акыркы чекити колдонмонун токенин гана кабыл алат.',
    'user_mismatch'         => 'Колдонуучу кирүү токенинин ээси эмес.',
    'client_mismatch'       => 'Twitch кардар ID ресурсту же токенди түзгөн ID эмес.',
    'no_organization'       => 'Twitch колдонмосу уюмга байланышкан эмес.',
    'multiple_filters'      => 'Twitch бир учурда бир гана чыпканы кабыл алат.',
    'malformed_parameter'   => '«:parameter» параметри туура түзүлгөн эмес.',
    'bad_identifiers'       => 'Twitch идентификаторлорунун бири же бир нечеси (ID, логиндер) жараксыз.',
    'invalid_code'          => 'Twitch авторизация коду жараксыз же мөөнөтү өткөн.',
    'invalid_refresh_token' => 'Twitch жаңыртуу токени жараксыз: колдонуучу кайра кириши керек.',
    'bad_request'           => 'Twitch өтүнүчтү четке какты.',
    'unauthorized'          => 'Twitch эсептик дайындарды четке какты.',
    'forbidden'             => 'Бул аракетке бул эсеп же колдонмо үчүн уруксат жок.',
    'not_found'             => 'Twitch бул өтүнүч боюнча эч нерсе таппады.',
    'conflict'              => 'Өтүнүч Twitch\'теги учурдагы абал менен карама-каршы келет.',
    'gone'                  => 'Twitch\'тин бул функциясы мындан ары жеткиликсиз.',
    'unprocessable'         => 'Twitch өтүнүчтү иштете алган жок.',
    'rate_limited'          => 'Twitch өтө көп өтүнүч алды. Кийинчерээк кайталап көрүңүз.',
    'server_error'          => 'Twitch\'те көйгөй бар. Кийинчерээк кайталап көрүңүз.',
    'network'               => 'Twitch\'ке туташуу мүмкүн болгон жок.',
    'error'                 => 'Twitch ката менен жооп берди.',
];
