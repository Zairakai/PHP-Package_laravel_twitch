<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitchi juurdepääsuluba on kehtetu või aegunud.',
    'missing_scope'         => 'Twitchi juurdepääsulubal puudub õigus (scope): :scope.',
    'app_token_required'    => 'See Twitchi lõpp-punkt aktsepteerib ainult rakenduse juurdepääsuluba.',
    'user_mismatch'         => 'Kasutaja ei ole juurdepääsuloa omanik.',
    'client_mismatch'       => 'Twitchi kliendi ID ei ole see, mis ressursi või loa lõi.',
    'no_organization'       => 'Twitchi rakendus ei ole organisatsiooniga seotud.',
    'multiple_filters'      => 'Twitch aktsepteerib korraga ainult ühte filtrit.',
    'malformed_parameter'   => 'Parameeter „:parameter“ on valesti vormistatud.',
    'bad_identifiers'       => 'Üks või mitu Twitchi identifikaatorit (ID-d, kasutajanimed) on kehtetud.',
    'invalid_code'          => 'Twitchi autoriseerimiskood on kehtetu või aegunud.',
    'invalid_refresh_token' => 'Twitchi värskenduslugu on kehtetu: kasutaja peab uuesti sisse logima.',
    'bad_request'           => 'Twitch lükkas päringu tagasi.',
    'unauthorized'          => 'Twitch lükkas mandaadid tagasi.',
    'forbidden'             => 'See toiming ei ole selle konto või rakenduse jaoks lubatud.',
    'not_found'             => 'Twitch ei leidnud selle päringu jaoks midagi.',
    'conflict'              => 'Päring on vastuolus Twitchi praeguse olekuga.',
    'gone'                  => 'See Twitchi funktsioon ei ole enam saadaval.',
    'unprocessable'         => 'Twitch ei suutnud päringut töödelda.',
    'rate_limited'          => 'Twitch sai liiga palju päringuid. Proovige hiljem uuesti.',
    'server_error'          => 'Twitchil on probleem. Proovige hiljem uuesti.',
    'network'               => 'Twitchiga ei õnnestunud ühendust saada.',
    'error'                 => 'Twitch vastas veaga.',
];
