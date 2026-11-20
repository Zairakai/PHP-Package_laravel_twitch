<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Het Twitch-toegangstoken is ongeldig of verlopen.',
    'missing_scope'         => 'Het Twitch-toegangstoken mist een machtiging (scope): :scope.',
    'app_token_required'    => 'Dit Twitch-eindpunt accepteert alleen een app-toegangstoken.',
    'user_mismatch'         => 'De gebruiker is niet de eigenaar van het toegangstoken.',
    'client_mismatch'       => 'De Twitch-client-ID is niet degene die de bron of het token heeft gemaakt.',
    'no_organization'       => 'De Twitch-applicatie is niet gekoppeld aan een organisatie.',
    'multiple_filters'      => 'Twitch accepteert maar één filter tegelijk.',
    'malformed_parameter'   => 'De parameter \':parameter\' is onjuist opgebouwd.',
    'bad_identifiers'       => 'Een of meer Twitch-identificatoren (ID\'s, logins) zijn ongeldig.',
    'invalid_code'          => 'De Twitch-autorisatiecode is ongeldig of verlopen.',
    'invalid_refresh_token' => 'Het Twitch-vernieuwingstoken is ongeldig: de gebruiker moet opnieuw inloggen.',
    'bad_request'           => 'Twitch heeft het verzoek geweigerd.',
    'unauthorized'          => 'Twitch heeft de inloggegevens geweigerd.',
    'forbidden'             => 'Deze actie is niet toegestaan voor dit account of deze applicatie.',
    'not_found'             => 'Twitch heeft niets gevonden voor dit verzoek.',
    'conflict'              => 'Het verzoek botst met de huidige status op Twitch.',
    'gone'                  => 'Deze Twitch-functie is niet meer beschikbaar.',
    'unprocessable'         => 'Twitch kon het verzoek niet verwerken.',
    'rate_limited'          => 'Twitch heeft te veel verzoeken ontvangen. Probeer het later opnieuw.',
    'server_error'          => 'Twitch heeft een probleem. Probeer het later opnieuw.',
    'network'               => 'Twitch is niet bereikbaar.',
    'error'                 => 'Twitch antwoordde met een fout.',
];
