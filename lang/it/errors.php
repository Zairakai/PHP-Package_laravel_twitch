<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Il token di accesso Twitch non è valido o è scaduto.',
    'missing_scope'         => 'Al token di accesso Twitch manca un permesso (scope): :scope.',
    'app_token_required'    => 'Questo endpoint Twitch accetta solo un token di applicazione.',
    'user_mismatch'         => 'L\'utente non è il proprietario del token di accesso.',
    'client_mismatch'       => 'L\'ID client Twitch non è quello che ha creato la risorsa o il token.',
    'no_organization'       => 'L\'applicazione Twitch non è collegata a un\'organizzazione.',
    'multiple_filters'      => 'Twitch accetta un solo filtro alla volta.',
    'malformed_parameter'   => 'Il parametro «:parameter» non è formato correttamente.',
    'bad_identifiers'       => 'Uno o più identificatori Twitch (ID, login) non sono validi.',
    'invalid_code'          => 'Il codice di autorizzazione Twitch non è valido o è scaduto.',
    'invalid_refresh_token' => 'Il token di aggiornamento Twitch non è valido: l\'utente deve accedere di nuovo.',
    'bad_request'           => 'Twitch ha rifiutato la richiesta.',
    'unauthorized'          => 'Twitch ha rifiutato le credenziali.',
    'forbidden'             => 'Questa azione non è consentita per questo account o questa applicazione.',
    'not_found'             => 'Twitch non ha trovato nulla per questa richiesta.',
    'conflict'              => 'La richiesta è in conflitto con lo stato attuale su Twitch.',
    'gone'                  => 'Questa funzione di Twitch non è più disponibile.',
    'unprocessable'         => 'Twitch non è riuscito a elaborare la richiesta.',
    'rate_limited'          => 'Twitch ha ricevuto troppe richieste. Riprova più tardi.',
    'server_error'          => 'Twitch ha un problema. Riprova più tardi.',
    'network'               => 'Impossibile raggiungere Twitch.',
    'error'                 => 'Twitch ha risposto con un errore.',
];
