<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'A Twitch hozzáférési token érvénytelen vagy lejárt.',
    'missing_scope'         => 'A Twitch hozzáférési tokenből hiányzik egy jogosultság (scope): :scope.',
    'app_token_required'    => 'Ez a Twitch végpont csak alkalmazás-hozzáférési tokent fogad el.',
    'user_mismatch'         => 'A felhasználó nem a hozzáférési token tulajdonosa.',
    'client_mismatch'       => 'A Twitch kliensazonosító nem az, amelyik az erőforrást vagy a tokent létrehozta.',
    'no_organization'       => 'A Twitch alkalmazás nincs szervezethez kapcsolva.',
    'multiple_filters'      => 'A Twitch egyszerre csak egy szűrőt fogad el.',
    'malformed_parameter'   => 'A(z) „:parameter” paraméter hibás.',
    'bad_identifiers'       => 'Egy vagy több Twitch azonosító (ID, felhasználónév) érvénytelen.',
    'invalid_code'          => 'A Twitch engedélyezési kód érvénytelen vagy lejárt.',
    'invalid_refresh_token' => 'A Twitch frissítési token érvénytelen: a felhasználónak újra be kell jelentkeznie.',
    'bad_request'           => 'A Twitch elutasította a kérést.',
    'unauthorized'          => 'A Twitch elutasította a hitelesítő adatokat.',
    'forbidden'             => 'Ez a művelet nem engedélyezett ennél a fióknál vagy alkalmazásnál.',
    'not_found'             => 'A Twitch nem talált semmit ehhez a kéréshez.',
    'conflict'              => 'A kérés ütközik a Twitch jelenlegi állapotával.',
    'gone'                  => 'Ez a Twitch-funkció már nem érhető el.',
    'unprocessable'         => 'A Twitch nem tudta feldolgozni a kérést.',
    'rate_limited'          => 'A Twitch túl sok kérést kapott. Próbálja újra később.',
    'server_error'          => 'A Twitch hibát észlelt. Próbálja újra később.',
    'network'               => 'A Twitch nem érhető el.',
    'error'                 => 'A Twitch hibával válaszolt.',
];
