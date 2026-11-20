<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Token dostępu Twitch jest nieprawidłowy lub wygasł.',
    'missing_scope'         => 'Tokenowi dostępu Twitch brakuje uprawnienia (scope): :scope.',
    'app_token_required'    => 'Ten punkt końcowy Twitch akceptuje tylko token aplikacji.',
    'user_mismatch'         => 'Użytkownik nie jest właścicielem tokenu dostępu.',
    'client_mismatch'       => 'Identyfikator klienta Twitch nie jest tym, który utworzył zasób lub token.',
    'no_organization'       => 'Aplikacja Twitch nie jest powiązana z organizacją.',
    'multiple_filters'      => 'Twitch akceptuje tylko jeden filtr naraz.',
    'malformed_parameter'   => 'Parametr „:parameter” jest nieprawidłowy.',
    'bad_identifiers'       => 'Co najmniej jeden identyfikator Twitch (ID, loginy) jest nieprawidłowy.',
    'invalid_code'          => 'Kod autoryzacji Twitch jest nieprawidłowy lub wygasł.',
    'invalid_refresh_token' => 'Token odświeżania Twitch jest nieprawidłowy: użytkownik musi zalogować się ponownie.',
    'bad_request'           => 'Twitch odrzucił żądanie.',
    'unauthorized'          => 'Twitch odrzucił dane uwierzytelniające.',
    'forbidden'             => 'Ta czynność nie jest dozwolona dla tego konta lub tej aplikacji.',
    'not_found'             => 'Twitch nic nie znalazł dla tego żądania.',
    'conflict'              => 'Żądanie jest sprzeczne z aktualnym stanem w Twitch.',
    'gone'                  => 'Ta funkcja Twitch nie jest już dostępna.',
    'unprocessable'         => 'Twitch nie mógł przetworzyć żądania.',
    'rate_limited'          => 'Twitch otrzymał zbyt wiele żądań. Spróbuj ponownie później.',
    'server_error'          => 'Twitch ma problem. Spróbuj ponownie później.',
    'network'               => 'Nie można połączyć się z Twitch.',
    'error'                 => 'Twitch odpowiedział błędem.',
];
