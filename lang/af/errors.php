<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Die Twitch-toegangsteken is ongeldig of het verval.',
    'missing_scope'         => 'Die Twitch-toegangsteken mis \'n toestemming (scope): :scope.',
    'app_token_required'    => 'Hierdie Twitch-eindpunt aanvaar slegs \'n toepassingstoegangsteken.',
    'user_mismatch'         => 'Die gebruiker is nie die eienaar van die toegangsteken nie.',
    'client_mismatch'       => 'Die Twitch-kliënt-ID is nie dié wat die hulpbron of die teken geskep het nie.',
    'no_organization'       => 'Die Twitch-toepassing is nie aan \'n organisasie gekoppel nie.',
    'multiple_filters'      => 'Twitch aanvaar net een filter op \'n slag.',
    'malformed_parameter'   => 'Die parameter ":parameter" is verkeerd gevorm.',
    'bad_identifiers'       => 'Een of meer Twitch-identifiseerders (ID\'s, aanmeldname) is ongeldig.',
    'invalid_code'          => 'Die Twitch-magtigingskode is ongeldig of het verval.',
    'invalid_refresh_token' => 'Die Twitch-hernuwingsteken is ongeldig: die gebruiker moet weer aanmeld.',
    'bad_request'           => 'Twitch het die versoek geweier.',
    'unauthorized'          => 'Twitch het die magtigingsbewyse geweier.',
    'forbidden'             => 'Hierdie aksie word nie vir hierdie rekening of toepassing toegelaat nie.',
    'not_found'             => 'Twitch het niks vir hierdie versoek gevind nie.',
    'conflict'              => 'Die versoek bots met die huidige toestand op Twitch.',
    'gone'                  => 'Hierdie Twitch-funksie is nie meer beskikbaar nie.',
    'unprocessable'         => 'Twitch kon die versoek nie verwerk nie.',
    'rate_limited'          => 'Twitch het te veel versoeke ontvang. Probeer later weer.',
    'server_error'          => 'Twitch het \'n probleem. Probeer later weer.',
    'network'               => 'Twitch kon nie bereik word nie.',
    'error'                 => 'Twitch het met \'n fout geantwoord.',
];
