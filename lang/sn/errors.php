<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Token yekupinda yeTwitch haina kusimba kana yapera nguva.',
    'missing_scope'         => 'Token yekupinda yeTwitch haina mvumo (scope): :scope.',
    'app_token_required'    => 'Endpoint iyi yeTwitch inogamuchira chete app access token.',
    'user_mismatch'         => 'Mushandisi haasi muridzi wetoken yekupinda.',
    'client_mismatch'       => 'Client ID yeTwitch haisi iyo yakagadzira rutsigiro kana token.',
    'no_organization'       => 'Application yeTwitch haina kubatanidzwa nesangano.',
    'multiple_filters'      => 'Twitch inogamuchira filter imwe chete panguva imwe.',
    'malformed_parameter'   => 'Parameter ":parameter" haina kugadzirwa zvakanaka.',
    'bad_identifiers'       => 'Chinzvimbo chimwe kana zvakawanda zveTwitch (ID, login) hazvina kusimba.',
    'invalid_code'          => 'Kodhi yemvumo yeTwitch haina kusimba kana yapera nguva.',
    'invalid_refresh_token' => 'Token yekuvandudza yeTwitch haina kusimba: mushandisi anofanira kupinda zvakare.',
    'bad_request'           => 'Twitch yaramba chikumbiro.',
    'unauthorized'          => 'Twitch yaramba zvitupa.',
    'forbidden'             => 'Chiito ichi hachibvumirwi kune account kana application iyi.',
    'not_found'             => 'Twitch haina kuwana chinhu pachikumbiro ichi.',
    'conflict'              => 'Chikumbiro chinopokana nemamiriro azvino paTwitch.',
    'gone'                  => 'Chimiro ichi cheTwitch hachisipo zvakare.',
    'unprocessable'         => 'Twitch haina kukwanisa kugadzirisa chikumbiro.',
    'rate_limited'          => 'Twitch yagamuchira zvikumbiro zvakawanda zvakanyanya. Edza zvakare gare gare.',
    'server_error'          => 'Twitch ine dambudziko. Edza zvakare gare gare.',
    'network'               => 'Twitch haina kukwanisa kusvikwa.',
    'error'                 => 'Twitch yapindura nekukanganisa.',
];
