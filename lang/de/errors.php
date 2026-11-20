<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Das Twitch-Zugriffstoken ist ungültig oder abgelaufen.',
    'missing_scope'         => 'Dem Twitch-Zugriffstoken fehlt eine Berechtigung (Scope): :scope.',
    'app_token_required'    => 'Dieser Twitch-Endpunkt akzeptiert nur ein App-Zugriffstoken.',
    'user_mismatch'         => 'Der Benutzer ist nicht der Besitzer des Zugriffstokens.',
    'client_mismatch'       => 'Die Twitch-Client-ID ist nicht die, die die Ressource oder das Token erstellt hat.',
    'no_organization'       => 'Die Twitch-Anwendung ist keiner Organisation zugeordnet.',
    'multiple_filters'      => 'Twitch akzeptiert nur einen Filter gleichzeitig.',
    'malformed_parameter'   => 'Der Parameter „:parameter“ ist fehlerhaft.',
    'bad_identifiers'       => 'Eine oder mehrere Twitch-Kennungen (IDs, Logins) sind ungültig.',
    'invalid_code'          => 'Der Twitch-Autorisierungscode ist ungültig oder abgelaufen.',
    'invalid_refresh_token' => 'Das Twitch-Aktualisierungstoken ist ungültig: Der Benutzer muss sich erneut anmelden.',
    'bad_request'           => 'Twitch hat die Anfrage abgelehnt.',
    'unauthorized'          => 'Twitch hat die Zugangsdaten abgelehnt.',
    'forbidden'             => 'Diese Aktion ist für dieses Konto oder diese Anwendung nicht erlaubt.',
    'not_found'             => 'Twitch hat zu dieser Anfrage nichts gefunden.',
    'conflict'              => 'Die Anfrage steht im Konflikt mit dem aktuellen Zustand bei Twitch.',
    'gone'                  => 'Diese Twitch-Funktion ist nicht mehr verfügbar.',
    'unprocessable'         => 'Twitch konnte die Anfrage nicht verarbeiten.',
    'rate_limited'          => 'Twitch hat zu viele Anfragen erhalten. Versuchen Sie es später erneut.',
    'server_error'          => 'Twitch hat ein Problem. Versuchen Sie es später erneut.',
    'network'               => 'Twitch ist nicht erreichbar.',
    'error'                 => 'Twitch hat mit einem Fehler geantwortet.',
];
