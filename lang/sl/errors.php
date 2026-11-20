<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Dostopni žeton Twitch je neveljaven ali je potekel.',
    'missing_scope'         => 'Dostopnemu žetonu Twitch manjka dovoljenje (scope): :scope.',
    'app_token_required'    => 'Ta končna točka Twitch sprejema samo dostopni žeton aplikacije.',
    'user_mismatch'         => 'Uporabnik ni lastnik dostopnega žetona.',
    'client_mismatch'       => 'ID odjemalca Twitch ni tisti, ki je ustvaril vir ali žeton.',
    'no_organization'       => 'Aplikacija Twitch ni povezana z organizacijo.',
    'multiple_filters'      => 'Twitch hkrati sprejme samo en filter.',
    'malformed_parameter'   => 'Parameter »:parameter« je napačno oblikovan.',
    'bad_identifiers'       => 'Eden ali več identifikatorjev Twitch (ID-ji, uporabniška imena) je neveljavnih.',
    'invalid_code'          => 'Avtorizacijska koda Twitch je neveljavna ali je potekla.',
    'invalid_refresh_token' => 'Žeton za osvežitev Twitch je neveljaven: uporabnik se mora znova prijaviti.',
    'bad_request'           => 'Twitch je zavrnil zahtevo.',
    'unauthorized'          => 'Twitch je zavrnil poverilnice.',
    'forbidden'             => 'To dejanje ni dovoljeno za ta račun ali to aplikacijo.',
    'not_found'             => 'Twitch za to zahtevo ni našel ničesar.',
    'conflict'              => 'Zahteva je v nasprotju s trenutnim stanjem na Twitchu.',
    'gone'                  => 'Ta funkcija Twitch ni več na voljo.',
    'unprocessable'         => 'Twitch ni mogel obdelati zahteve.',
    'rate_limited'          => 'Twitch je prejel preveč zahtev. Poskusite znova pozneje.',
    'server_error'          => 'Twitch ima težavo. Poskusite znova pozneje.',
    'network'               => 'S Twitchem ni bilo mogoče vzpostaviti povezave.',
    'error'                 => 'Twitch je odgovoril z napako.',
];
