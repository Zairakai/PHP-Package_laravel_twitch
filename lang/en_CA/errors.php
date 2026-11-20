<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'The Twitch access token is invalid or has expired.',
    'missing_scope'         => 'The Twitch access token is missing a scope: :scope.',
    'app_token_required'    => 'This Twitch endpoint accepts only an app access token.',
    'user_mismatch'         => 'The user is not the owner of the access token.',
    'client_mismatch'       => 'The Twitch client ID is not the one that created the resource or the token.',
    'no_organization'       => 'The Twitch application is not linked to an organization.',
    'multiple_filters'      => 'Twitch accepts only one filter at a time.',
    'malformed_parameter'   => 'The parameter ":parameter" is malformed.',
    'bad_identifiers'       => 'One or more Twitch identifiers (IDs, logins) are invalid.',
    'invalid_code'          => 'The Twitch authorization code is invalid or has expired.',
    'invalid_refresh_token' => 'The Twitch refresh token is invalid: the user must connect again.',
    'bad_request'           => 'Twitch refused the request.',
    'unauthorized'          => 'Twitch refused the credentials.',
    'forbidden'             => 'This action is not allowed for this account or this application.',
    'not_found'             => 'Twitch found nothing for this request.',
    'conflict'              => 'The request conflicts with the current state on Twitch.',
    'gone'                  => 'This Twitch feature is no longer available.',
    'unprocessable'         => 'Twitch could not process the request.',
    'rate_limited'          => 'Twitch received too many requests. Try again later.',
    'server_error'          => 'Twitch is having a problem. Try again later.',
    'network'               => 'Twitch could not be reached.',
    'error'                 => 'Twitch answered with an error.',
];
