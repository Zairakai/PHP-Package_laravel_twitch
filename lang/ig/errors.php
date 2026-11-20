<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Tokin nnweta Twitch adịghị mma ma ọ bụ ọ gafeela oge.',
    'missing_scope'         => 'Tokin nnweta Twitch enweghị ikike (scope): :scope.',
    'app_token_required'    => 'Njedebe Twitch a na-anabata naanị tokin nnweta ngwa.',
    'user_mismatch'         => 'Onye ọrụ abụghị onye nwe tokin nnweta.',
    'client_mismatch'       => 'ID onye ahịa Twitch abụghị nke mepụtara akụrụngwa ma ọ bụ tokin.',
    'no_organization'       => 'Ejikọghị ngwa Twitch na nzukọ.',
    'multiple_filters'      => 'Twitch na-anabata naanị otu nchọgharị n\'otu oge.',
    'malformed_parameter'   => 'Paramita ":parameter" abụghị nke e mere nke ọma.',
    'bad_identifiers'       => 'Otu ma ọ bụ ọtụtụ njirimara Twitch (ID, mbanye) adịghị mma.',
    'invalid_code'          => 'Koodu ikike Twitch adịghị mma ma ọ bụ ọ gafeela oge.',
    'invalid_refresh_token' => 'Tokin nchọgharị Twitch adịghị mma: onye ọrụ aghaghị ịbanye ọzọ.',
    'bad_request'           => 'Twitch jụrụ arịrịọ ahụ.',
    'unauthorized'          => 'Twitch jụrụ asambodo ndị ahụ.',
    'forbidden'             => 'Anaghị ekwe ya ka e mee ihe a maka akaụntụ ma ọ bụ ngwa a.',
    'not_found'             => 'Twitch achọtaghị ihe ọ bụla maka arịrịọ a.',
    'conflict'              => 'Arịrịọ ahụ na-emegide ọnọdụ ugbu a na Twitch.',
    'gone'                  => 'Atụmatụ Twitch a adịghịzi.',
    'unprocessable'         => 'Twitch enweghị ike ịrụ arịrịọ ahụ.',
    'rate_limited'          => 'Twitch natara arịrịọ dị ukwuu. Nwaa ọzọ mgbe e mesịrị.',
    'server_error'          => 'Twitch nwere nsogbu. Nwaa ọzọ mgbe e mesịrị.',
    'network'               => 'Enweghị ike iru Twitch.',
    'error'                 => 'Twitch zara na njehie.',
];
