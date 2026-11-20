<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch-tilgangstokenet er ugyldig eller utgått.',
    'missing_scope'         => 'Twitch-tilgangstokenet manglar ei løyve (scope): :scope.',
    'app_token_required'    => 'Dette Twitch-endepunktet godtek berre eit app-tilgangstoken.',
    'user_mismatch'         => 'Brukaren er ikkje eigar av tilgangstokenet.',
    'client_mismatch'       => 'Twitch-klient-ID-en er ikkje den som oppretta ressursen eller tokenet.',
    'no_organization'       => 'Twitch-applikasjonen er ikkje knytt til ein organisasjon.',
    'multiple_filters'      => 'Twitch godtek berre eitt filter om gongen.',
    'malformed_parameter'   => 'Parameteren «:parameter» er feil utforma.',
    'bad_identifiers'       => 'Ein eller fleire Twitch-identifikatorar (ID-ar, innloggingar) er ugyldige.',
    'invalid_code'          => 'Twitch-autorisasjonskoden er ugyldig eller utgått.',
    'invalid_refresh_token' => 'Twitch-fornyingstokenet er ugyldig: brukaren må logge inn på nytt.',
    'bad_request'           => 'Twitch avviste førespurnaden.',
    'unauthorized'          => 'Twitch avviste legitimasjonen.',
    'forbidden'             => 'Denne handlinga er ikkje tillaten for denne kontoen eller denne applikasjonen.',
    'not_found'             => 'Twitch fann ingenting for denne førespurnaden.',
    'conflict'              => 'Førespurnaden er i konflikt med den noverande tilstanden på Twitch.',
    'gone'                  => 'Denne Twitch-funksjonen er ikkje lenger tilgjengeleg.',
    'unprocessable'         => 'Twitch kunne ikkje behandle førespurnaden.',
    'rate_limited'          => 'Twitch har fått for mange førespurnader. Prøv igjen seinare.',
    'server_error'          => 'Twitch har eit problem. Prøv igjen seinare.',
    'network'               => 'Twitch kunne ikkje nåast.',
    'error'                 => 'Twitch svara med ein feil.',
];
