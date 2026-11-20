<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Prístupový token Twitch je neplatný alebo vypršal.',
    'missing_scope'         => 'Prístupovému tokenu Twitch chýba oprávnenie (scope): :scope.',
    'app_token_required'    => 'Tento koncový bod Twitch prijíma iba token aplikácie.',
    'user_mismatch'         => 'Používateľ nie je vlastníkom prístupového tokenu.',
    'client_mismatch'       => 'ID klienta Twitch nie je to, ktoré vytvorilo zdroj alebo token.',
    'no_organization'       => 'Aplikácia Twitch nie je prepojená s organizáciou.',
    'multiple_filters'      => 'Twitch prijíma naraz iba jeden filter.',
    'malformed_parameter'   => 'Parameter „:parameter“ je nesprávne zadaný.',
    'bad_identifiers'       => 'Jeden alebo viac identifikátorov Twitch (ID, prihlasovacie mená) je neplatných.',
    'invalid_code'          => 'Autorizačný kód Twitch je neplatný alebo vypršal.',
    'invalid_refresh_token' => 'Obnovovací token Twitch je neplatný: používateľ sa musí prihlásiť znova.',
    'bad_request'           => 'Twitch požiadavku odmietol.',
    'unauthorized'          => 'Twitch odmietol prihlasovacie údaje.',
    'forbidden'             => 'Táto akcia nie je pre tento účet alebo túto aplikáciu povolená.',
    'not_found'             => 'Twitch pre túto požiadavku nič nenašiel.',
    'conflict'              => 'Požiadavka je v rozpore s aktuálnym stavom na Twitch.',
    'gone'                  => 'Táto funkcia Twitch už nie je dostupná.',
    'unprocessable'         => 'Twitch nedokázal požiadavku spracovať.',
    'rate_limited'          => 'Twitch dostal príliš veľa požiadaviek. Skúste to neskôr.',
    'server_error'          => 'Twitch má problém. Skúste to neskôr.',
    'network'               => 'S Twitch sa nepodarilo spojiť.',
    'error'                 => 'Twitch odpovedal chybou.',
];
