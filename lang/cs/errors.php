<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Přístupový token Twitch je neplatný nebo vypršel.',
    'missing_scope'         => 'Přístupovému tokenu Twitch chybí oprávnění (scope): :scope.',
    'app_token_required'    => 'Tento koncový bod Twitch přijímá pouze token aplikace.',
    'user_mismatch'         => 'Uživatel není vlastníkem přístupového tokenu.',
    'client_mismatch'       => 'ID klienta Twitch není to, které vytvořilo zdroj nebo token.',
    'no_organization'       => 'Aplikace Twitch není propojena s žádnou organizací.',
    'multiple_filters'      => 'Twitch přijímá vždy pouze jeden filtr.',
    'malformed_parameter'   => 'Parametr „:parameter“ je chybně zadán.',
    'bad_identifiers'       => 'Jeden nebo více identifikátorů Twitch (ID, loginy) je neplatných.',
    'invalid_code'          => 'Autorizační kód Twitch je neplatný nebo vypršel.',
    'invalid_refresh_token' => 'Obnovovací token Twitch je neplatný: uživatel se musí přihlásit znovu.',
    'bad_request'           => 'Twitch požadavek odmítl.',
    'unauthorized'          => 'Twitch odmítl přihlašovací údaje.',
    'forbidden'             => 'Tato akce není pro tento účet nebo tuto aplikaci povolena.',
    'not_found'             => 'Twitch pro tento požadavek nic nenašel.',
    'conflict'              => 'Požadavek je v rozporu s aktuálním stavem na Twitch.',
    'gone'                  => 'Tato funkce Twitch již není dostupná.',
    'unprocessable'         => 'Twitch nemohl požadavek zpracovat.',
    'rate_limited'          => 'Twitch obdržel příliš mnoho požadavků. Zkuste to později.',
    'server_error'          => 'Twitch má problém. Zkuste to později.',
    'network'               => 'Twitch není dostupný.',
    'error'                 => 'Twitch odpověděl chybou.',
];
