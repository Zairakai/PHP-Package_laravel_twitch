<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Su token de atzessu de Twitch no est vàlidu o est iscadidu.',
    'missing_scope'         => 'A su token de atzessu de Twitch li mancat unu permissu (scope): :scope.',
    'app_token_required'    => 'Custu puntu finale de Twitch atzetat isceti unu token de atzessu de aplicatzione.',
    'user_mismatch'         => 'S\'utente no est su mere de su token de atzessu.',
    'client_mismatch'       => 'S\'ID de cliente de Twitch no est cussu chi at creadu sa risorsa o su token.',
    'no_organization'       => 'S\'aplicatzione de Twitch no est ligada a un\'organizatzione.',
    'multiple_filters'      => 'Twitch atzetat isceti unu filtru a sa borta.',
    'malformed_parameter'   => 'Su paràmetru «:parameter» no est formadu bene.',
    'bad_identifiers'       => 'Unu o prus identificadores de Twitch (ID, nùmenes de atzessu) no sunt vàlidos.',
    'invalid_code'          => 'Su còdighe de autorizatzione de Twitch no est vàlidu o est iscadidu.',
    'invalid_refresh_token' => 'Su token de agiornamentu de Twitch no est vàlidu: s\'utente depet intrare torra.',
    'bad_request'           => 'Twitch at refudadu sa rechesta.',
    'unauthorized'          => 'Twitch at refudadu is credentziales.',
    'forbidden'             => 'Custa atzione no est permìtida pro custu contu o custa aplicatzione.',
    'not_found'             => 'Twitch no at agatadu nudda pro custa rechesta.',
    'conflict'              => 'Sa rechesta est in cunflitu cun s\'istadu atuale in Twitch.',
    'gone'                  => 'Custa funtzionalidade de Twitch no est prus a disponimentu.',
    'unprocessable'         => 'Twitch no at pòdidu elaborare sa rechesta.',
    'rate_limited'          => 'Twitch at retzidu tropu rechestas. Torra a proare prus tardu.',
    'server_error'          => 'Twitch tenet unu problema. Torra a proare prus tardu.',
    'network'               => 'Non s\'est pòdidu cuntatare Twitch.',
    'error'                 => 'Twitch at rispostu cun un\'errore.',
];
