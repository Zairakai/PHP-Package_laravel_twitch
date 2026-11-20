<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Tokenii Twitch galmaa\'uu hin sirrii miti ykn yeroon isaa darbeera.',
    'missing_scope'         => 'Tokenii Twitch galmaa\'uu eeyyama (scope) hin qabu: :scope.',
    'app_token_required'    => 'Dhuma Twitch kun tokenii app galmaa\'uu qofa fudhata.',
    'user_mismatch'         => 'Fayyadamaan abbaa tokenii galmaa\'uu miti.',
    'client_mismatch'       => 'ID maamilaa Twitch kan qabeenya ykn tokenii uume miti.',
    'no_organization'       => 'Appiin Twitch dhaabbata tokko waliin hin wal qabatu.',
    'multiple_filters'      => 'Twitch yeroo tokkotti calallii tokko qofa fudhata.',
    'malformed_parameter'   => 'Parameeteriin ":parameter" sirnaan hin tolfamne.',
    'bad_identifiers'       => 'Eenyummaa Twitch tokko ykn isaa ol (ID, galmee) sirrii miti.',
    'invalid_code'          => 'Koodiin hayyama Twitch sirrii miti ykn yeroon isaa darbeera.',
    'invalid_refresh_token' => 'Tokenii haaromsaa Twitch sirrii miti: fayyadamaan irra deebi\'ee galuu qaba.',
    'bad_request'           => 'Twitch gaaffii kana didee jira.',
    'unauthorized'          => 'Twitch ragaalee ofitti himuu didee jira.',
    'forbidden'             => 'Gochi kun akkaawuntii ykn appii kanaaf hayyamamaa miti.',
    'not_found'             => 'Twitch gaaffii kanaaf homaa hin argine.',
    'conflict'              => 'Gaaffiin kun haala amma Twitch irra jiru waliin wal falaa.',
    'gone'                  => 'Amaloonni Twitch kun amma hin argamu.',
    'unprocessable'         => 'Twitch gaaffii kana hojjechuu hin dandeenye.',
    'rate_limited'          => 'Twitch gaaffii baay\'ee argate. Booda irra deebi\'ii yaali.',
    'server_error'          => 'Twitch rakkoo qaba. Booda irra deebi\'ii yaali.',
    'network'               => 'Twitch quunnamuu hin dandeenye.',
    'error'                 => 'Twitch dogoggoraan deebiseera.',
];
