<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Den Twitch-Zougrëffstoken ass ongülteg oder ofgelaf.',
    'missing_scope'         => 'Dem Twitch-Zougrëffstoken feelt eng Erlaabnis (Scope): :scope.',
    'app_token_required'    => 'Dësen Twitch-Endpunkt akzeptéiert nëmmen en App-Zougrëffstoken.',
    'user_mismatch'         => 'De Benotzer ass net de Besëtzer vum Zougrëffstoken.',
    'client_mismatch'       => 'D\'Twitch-Client-ID ass net déi, déi d\'Ressource oder den Token erstallt huet.',
    'no_organization'       => 'D\'Twitch-Applikatioun ass net mat enger Organisatioun verbonnen.',
    'multiple_filters'      => 'Twitch akzeptéiert nëmmen ee Filter op eemol.',
    'malformed_parameter'   => 'De Parameter „:parameter“ ass falsch opgebaut.',
    'bad_identifiers'       => 'Een oder méi Twitch-Identifikatoren (IDen, Login-Nimm) sinn ongülteg.',
    'invalid_code'          => 'Den Twitch-Autorisatiounscode ass ongülteg oder ofgelaf.',
    'invalid_refresh_token' => 'Den Twitch-Erneierungstoken ass ongülteg: De Benotzer muss sech nei umellen.',
    'bad_request'           => 'Twitch huet d\'Ufro ofgeleent.',
    'unauthorized'          => 'Twitch huet d\'Umeldedaten ofgeleent.',
    'forbidden'             => 'Dës Aktioun ass fir dëse Kont oder dës Applikatioun net erlaabt.',
    'not_found'             => 'Twitch huet näischt fir dës Ufro fonnt.',
    'conflict'              => 'D\'Ufro steet am Konflikt mam aktuellen Zoustand op Twitch.',
    'gone'                  => 'Dës Twitch-Funktioun ass net méi verfügbar.',
    'unprocessable'         => 'Twitch konnt d\'Ufro net verschaffen.',
    'rate_limited'          => 'Twitch huet ze vill Ufroe kritt. Probéiert et méi spéit nach eng Kéier.',
    'server_error'          => 'Twitch huet e Problem. Probéiert et méi spéit nach eng Kéier.',
    'network'               => 'Twitch konnt net erreecht ginn.',
    'error'                 => 'Twitch huet mat engem Feeler geäntwert.',
];
