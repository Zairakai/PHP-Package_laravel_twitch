<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch қол жеткізу токені жарамсыз немесе мерзімі өткен.',
    'missing_scope'         => 'Twitch қол жеткізу токенінде рұқсат (scope) жоқ: :scope.',
    'app_token_required'    => 'Бұл Twitch соңғы нүктесі тек қолданба токенін қабылдайды.',
    'user_mismatch'         => 'Пайдаланушы қол жеткізу токенінің иесі емес.',
    'client_mismatch'       => 'Twitch клиент ID-і ресурсты немесе токенді жасаған ID емес.',
    'no_organization'       => 'Twitch қолданбасы ұйыммен байланыспаған.',
    'multiple_filters'      => 'Twitch бір уақытта тек бір сүзгіні қабылдайды.',
    'malformed_parameter'   => '«:parameter» параметрі дұрыс жасалмаған.',
    'bad_identifiers'       => 'Twitch идентификаторларының біреуі немесе бірнешеуі (ID, логиндер) жарамсыз.',
    'invalid_code'          => 'Twitch авторизация коды жарамсыз немесе мерзімі өткен.',
    'invalid_refresh_token' => 'Twitch жаңарту токені жарамсыз: пайдаланушы қайта кіруі керек.',
    'bad_request'           => 'Twitch сұрауды қабылдамады.',
    'unauthorized'          => 'Twitch тіркелгі деректерін қабылдамады.',
    'forbidden'             => 'Бұл әрекетке осы тіркелгі немесе қолданба үшін рұқсат жоқ.',
    'not_found'             => 'Twitch бұл сұрау бойынша ештеңе таппады.',
    'conflict'              => 'Сұрау Twitch-тегі ағымдағы күймен қайшы келеді.',
    'gone'                  => 'Twitch-тің бұл функциясы енді қолжетімсіз.',
    'unprocessable'         => 'Twitch сұрауды өңдей алмады.',
    'rate_limited'          => 'Twitch тым көп сұрау алды. Кейінірек қайталап көріңіз.',
    'server_error'          => 'Twitch-те ақау бар. Кейінірек қайталап көріңіз.',
    'network'               => 'Twitch-ке қосылу мүмкін болмады.',
    'error'                 => 'Twitch қатемен жауап берді.',
];
