<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch-en sarbide-tokena baliogabea da edo iraungi da.',
    'missing_scope'         => 'Twitch-en sarbide-tokenak baimen bat (scope) falta du: :scope.',
    'app_token_required'    => 'Twitch-en amaiera-puntu honek aplikazio-sarbide tokena soilik onartzen du.',
    'user_mismatch'         => 'Erabiltzailea ez da sarbide-tokenaren jabea.',
    'client_mismatch'       => 'Twitch-en bezero IDa ez da baliabidea edo tokena sortu duena.',
    'no_organization'       => 'Twitch aplikazioa ez dago erakunde bati lotuta.',
    'multiple_filters'      => 'Twitch-ek iragazki bakarra onartzen du aldi berean.',
    'malformed_parameter'   => '":parameter" parametroa gaizki osatuta dago.',
    'bad_identifiers'       => 'Twitch-en identifikatzaile bat edo gehiago (ID, saio-izenak) baliogabeak dira.',
    'invalid_code'          => 'Twitch-en baimen-kodea baliogabea da edo iraungi da.',
    'invalid_refresh_token' => 'Twitch-en eguneratze-tokena baliogabea da: erabiltzaileak berriro hasi behar du saioa.',
    'bad_request'           => 'Twitch-ek eskaera ukatu du.',
    'unauthorized'          => 'Twitch-ek kredentzialak ukatu ditu.',
    'forbidden'             => 'Ekintza hau ez dago baimenduta kontu edo aplikazio honetarako.',
    'not_found'             => 'Twitch-ek ez du ezer aurkitu eskaera honetarako.',
    'conflict'              => 'Eskaera Twitch-en uneko egoerarekin gatazkan dago.',
    'gone'                  => 'Twitch-en eginbide hau ez dago eskuragarri jada.',
    'unprocessable'         => 'Twitch-ek ezin izan du eskaera prozesatu.',
    'rate_limited'          => 'Twitch-ek eskaera gehiegi jaso ditu. Saiatu berriro geroago.',
    'server_error'          => 'Twitch-ek arazo bat du. Saiatu berriro geroago.',
    'network'               => 'Ezin izan da Twitch-ekin konektatu.',
    'error'                 => 'Twitch-ek errore batekin erantzun du.',
];
