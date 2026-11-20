<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch-adgangstokenet er ugyldigt eller udløbet.',
    'missing_scope'         => 'Twitch-adgangstokenet mangler en tilladelse (scope): :scope.',
    'app_token_required'    => 'Dette Twitch-endepunkt accepterer kun et app-adgangstoken.',
    'user_mismatch'         => 'Brugeren er ikke ejer af adgangstokenet.',
    'client_mismatch'       => 'Twitch-klient-id\'et er ikke det, der oprettede ressourcen eller tokenet.',
    'no_organization'       => 'Twitch-applikationen er ikke knyttet til en organisation.',
    'multiple_filters'      => 'Twitch accepterer kun ét filter ad gangen.',
    'malformed_parameter'   => 'Parameteren ":parameter" er forkert udformet.',
    'bad_identifiers'       => 'Et eller flere Twitch-id\'er (ID\'er, logins) er ugyldige.',
    'invalid_code'          => 'Twitch-autorisationskoden er ugyldig eller udløbet.',
    'invalid_refresh_token' => 'Twitch-opdateringstokenet er ugyldigt: brugeren skal logge ind igen.',
    'bad_request'           => 'Twitch afviste anmodningen.',
    'unauthorized'          => 'Twitch afviste legitimationsoplysningerne.',
    'forbidden'             => 'Denne handling er ikke tilladt for denne konto eller denne applikation.',
    'not_found'             => 'Twitch fandt intet til denne anmodning.',
    'conflict'              => 'Anmodningen er i konflikt med den aktuelle tilstand på Twitch.',
    'gone'                  => 'Denne Twitch-funktion er ikke længere tilgængelig.',
    'unprocessable'         => 'Twitch kunne ikke behandle anmodningen.',
    'rate_limited'          => 'Twitch har modtaget for mange anmodninger. Prøv igen senere.',
    'server_error'          => 'Twitch har et problem. Prøv igen senere.',
    'network'               => 'Twitch kunne ikke nås.',
    'error'                 => 'Twitch svarede med en fejl.',
];
