<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => '„Twitch“ prieigos raktas negaliojantis arba nebegalioja.',
    'missing_scope'         => '„Twitch“ prieigos rakto trūksta leidimo (scope): :scope.',
    'app_token_required'    => 'Šis „Twitch“ galutinis taškas priima tik programos prieigos raktą.',
    'user_mismatch'         => 'Naudotojas nėra prieigos rakto savininkas.',
    'client_mismatch'       => '„Twitch“ kliento ID nėra tas, kuris sukūrė išteklių ar raktą.',
    'no_organization'       => '„Twitch“ programa nėra susieta su organizacija.',
    'multiple_filters'      => '„Twitch“ vienu metu priima tik vieną filtrą.',
    'malformed_parameter'   => 'Parametras „:parameter“ netinkamai suformuotas.',
    'bad_identifiers'       => 'Vienas ar keli „Twitch“ identifikatoriai (ID, prisijungimo vardai) negalioja.',
    'invalid_code'          => '„Twitch“ autorizacijos kodas negaliojantis arba nebegalioja.',
    'invalid_refresh_token' => '„Twitch“ atnaujinimo raktas negaliojantis: naudotojas turi prisijungti iš naujo.',
    'bad_request'           => '„Twitch“ atmetė užklausą.',
    'unauthorized'          => '„Twitch“ atmetė prisijungimo duomenis.',
    'forbidden'             => 'Šis veiksmas neleidžiamas šiai paskyrai ar programai.',
    'not_found'             => '„Twitch“ šiai užklausai nieko nerado.',
    'conflict'              => 'Užklausa prieštarauja dabartinei „Twitch“ būsenai.',
    'gone'                  => 'Ši „Twitch“ funkcija nebepasiekiama.',
    'unprocessable'         => '„Twitch“ nepavyko apdoroti užklausos.',
    'rate_limited'          => '„Twitch“ gavo per daug užklausų. Bandykite vėliau.',
    'server_error'          => '„Twitch“ kilo problema. Bandykite vėliau.',
    'network'               => 'Nepavyko susisiekti su „Twitch“.',
    'error'                 => '„Twitch“ atsakė klaida.',
];
