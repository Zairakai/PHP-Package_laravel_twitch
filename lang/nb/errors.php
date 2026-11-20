<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch-tilgangstokenet er ugyldig eller utløpt.',
    'missing_scope'         => 'Twitch-tilgangstokenet mangler en tillatelse (scope): :scope.',
    'app_token_required'    => 'Dette Twitch-endepunktet godtar bare et app-tilgangstoken.',
    'user_mismatch'         => 'Brukeren er ikke eier av tilgangstokenet.',
    'client_mismatch'       => 'Twitch-klient-ID-en er ikke den som opprettet ressursen eller tokenet.',
    'no_organization'       => 'Twitch-applikasjonen er ikke knyttet til en organisasjon.',
    'multiple_filters'      => 'Twitch godtar bare ett filter om gangen.',
    'malformed_parameter'   => 'Parameteren «:parameter» er feil utformet.',
    'bad_identifiers'       => 'En eller flere Twitch-identifikatorer (ID-er, innlogginger) er ugyldige.',
    'invalid_code'          => 'Twitch-autorisasjonskoden er ugyldig eller utløpt.',
    'invalid_refresh_token' => 'Twitch-fornyelsestokenet er ugyldig: brukeren må logge inn på nytt.',
    'bad_request'           => 'Twitch avviste forespørselen.',
    'unauthorized'          => 'Twitch avviste legitimasjonen.',
    'forbidden'             => 'Denne handlingen er ikke tillatt for denne kontoen eller denne applikasjonen.',
    'not_found'             => 'Twitch fant ingenting for denne forespørselen.',
    'conflict'              => 'Forespørselen er i konflikt med den nåværende tilstanden på Twitch.',
    'gone'                  => 'Denne Twitch-funksjonen er ikke lenger tilgjengelig.',
    'unprocessable'         => 'Twitch kunne ikke behandle forespørselen.',
    'rate_limited'          => 'Twitch har mottatt for mange forespørsler. Prøv igjen senere.',
    'server_error'          => 'Twitch har et problem. Prøv igjen senere.',
    'network'               => 'Twitch kunne ikke nås.',
    'error'                 => 'Twitch svarte med en feil.',
];
