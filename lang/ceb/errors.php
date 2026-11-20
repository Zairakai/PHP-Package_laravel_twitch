<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Ang Twitch access token dili balido o nag-expire na.',
    'missing_scope'         => 'Ang Twitch access token nawad-an og permiso (scope): :scope.',
    'app_token_required'    => 'Kini nga Twitch endpoint modawat lang og app access token.',
    'user_mismatch'         => 'Ang tiggamit dili tag-iya sa access token.',
    'client_mismatch'       => 'Ang Twitch client ID dili kadtong naghimo sa kapanguhaan o sa token.',
    'no_organization'       => 'Ang Twitch application wala konektado sa usa ka organisasyon.',
    'multiple_filters'      => 'Ang Twitch modawat lang og usa ka filter sa matag higayon.',
    'malformed_parameter'   => 'Ang parameter nga ":parameter" sayop ang pagkahimo.',
    'bad_identifiers'       => 'Usa o daghan pa nga Twitch identifier (ID, login) dili balido.',
    'invalid_code'          => 'Ang Twitch authorization code dili balido o nag-expire na.',
    'invalid_refresh_token' => 'Ang Twitch refresh token dili balido: kinahanglang mo-login pag-usab ang tiggamit.',
    'bad_request'           => 'Gisalikway sa Twitch ang hangyo.',
    'unauthorized'          => 'Gisalikway sa Twitch ang mga kredensyal.',
    'forbidden'             => 'Kini nga aksyon dili gitugotan alang niini nga account o application.',
    'not_found'             => 'Walay nakit-an ang Twitch alang niini nga hangyo.',
    'conflict'              => 'Ang hangyo nagkasumpaki sa karon nga kahimtang sa Twitch.',
    'gone'                  => 'Kini nga Twitch feature dili na magamit.',
    'unprocessable'         => 'Dili maproseso sa Twitch ang hangyo.',
    'rate_limited'          => 'Daghan kaayo og hangyo ang nadawat sa Twitch. Sulayi pag-usab sa ulahi.',
    'server_error'          => 'Adunay problema ang Twitch. Sulayi pag-usab sa ulahi.',
    'network'               => 'Dili maabot ang Twitch.',
    'error'                 => 'Mitubag ang Twitch og sayop.',
];
