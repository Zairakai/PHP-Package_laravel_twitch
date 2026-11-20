<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch-åtkomsttoken är ogiltig eller har gått ut.',
    'missing_scope'         => 'Twitch-åtkomsttoken saknar en behörighet (scope): :scope.',
    'app_token_required'    => 'Den här Twitch-slutpunkten accepterar bara en apptoken.',
    'user_mismatch'         => 'Användaren är inte ägare till åtkomsttoken.',
    'client_mismatch'       => 'Twitch-klient-ID:t är inte det som skapade resursen eller token.',
    'no_organization'       => 'Twitch-applikationen är inte kopplad till en organisation.',
    'multiple_filters'      => 'Twitch accepterar bara ett filter åt gången.',
    'malformed_parameter'   => 'Parametern ":parameter" är felaktigt formad.',
    'bad_identifiers'       => 'Ett eller flera Twitch-ID:n (ID, inloggningar) är ogiltiga.',
    'invalid_code'          => 'Twitch-auktoriseringskoden är ogiltig eller har gått ut.',
    'invalid_refresh_token' => 'Twitch-förnyelsetoken är ogiltig: användaren måste logga in igen.',
    'bad_request'           => 'Twitch avvisade begäran.',
    'unauthorized'          => 'Twitch avvisade inloggningsuppgifterna.',
    'forbidden'             => 'Den här åtgärden är inte tillåten för det här kontot eller den här applikationen.',
    'not_found'             => 'Twitch hittade inget för den här begäran.',
    'conflict'              => 'Begäran står i konflikt med det nuvarande tillståndet på Twitch.',
    'gone'                  => 'Den här Twitch-funktionen är inte längre tillgänglig.',
    'unprocessable'         => 'Twitch kunde inte behandla begäran.',
    'rate_limited'          => 'Twitch har fått för många begäranden. Försök igen senare.',
    'server_error'          => 'Twitch har ett problem. Försök igen senare.',
    'network'               => 'Twitch kunde inte nås.',
    'error'                 => 'Twitch svarade med ett fel.',
];
