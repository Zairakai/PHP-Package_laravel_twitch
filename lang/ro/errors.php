<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Tokenul de acces Twitch este invalid sau a expirat.',
    'missing_scope'         => 'Tokenului de acces Twitch îi lipsește o permisiune (scope): :scope.',
    'app_token_required'    => 'Acest punct final Twitch acceptă doar un token de aplicație.',
    'user_mismatch'         => 'Utilizatorul nu este proprietarul tokenului de acces.',
    'client_mismatch'       => 'ID-ul de client Twitch nu este cel care a creat resursa sau tokenul.',
    'no_organization'       => 'Aplicația Twitch nu este asociată unei organizații.',
    'multiple_filters'      => 'Twitch acceptă un singur filtru la un moment dat.',
    'malformed_parameter'   => 'Parametrul „:parameter” este formulat greșit.',
    'bad_identifiers'       => 'Unul sau mai mulți identificatori Twitch (ID-uri, login-uri) sunt invalizi.',
    'invalid_code'          => 'Codul de autorizare Twitch este invalid sau a expirat.',
    'invalid_refresh_token' => 'Tokenul de reîmprospătare Twitch este invalid: utilizatorul trebuie să se conecteze din nou.',
    'bad_request'           => 'Twitch a refuzat cererea.',
    'unauthorized'          => 'Twitch a refuzat datele de autentificare.',
    'forbidden'             => 'Această acțiune nu este permisă pentru acest cont sau această aplicație.',
    'not_found'             => 'Twitch nu a găsit nimic pentru această cerere.',
    'conflict'              => 'Cererea intră în conflict cu starea curentă de pe Twitch.',
    'gone'                  => 'Această funcție Twitch nu mai este disponibilă.',
    'unprocessable'         => 'Twitch nu a putut procesa cererea.',
    'rate_limited'          => 'Twitch a primit prea multe cereri. Încercați din nou mai târziu.',
    'server_error'          => 'Twitch are o problemă. Încercați din nou mai târziu.',
    'network'               => 'Twitch nu poate fi contactat.',
    'error'                 => 'Twitch a răspuns cu o eroare.',
];
