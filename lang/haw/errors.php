<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'ʻAʻole kūpono ka hōʻailona komo Twitch a ua pau ka manawa.',
    'missing_scope'         => 'Nele ka hōʻailona komo Twitch i ka ʻae (scope): :scope.',
    'app_token_required'    => 'ʻAe wale kēia wahi hope o Twitch i ka hōʻailona komo polokalamu.',
    'user_mismatch'         => 'ʻAʻole ka mea hoʻohana ka mea nona ka hōʻailona komo.',
    'client_mismatch'       => 'ʻAʻole ka ID mea kūʻai Twitch ka mea nāna i hana i ka waiwai a i ʻole ka hōʻailona.',
    'no_organization'       => 'ʻAʻole pili ka polokalamu Twitch i kekahi hui.',
    'multiple_filters'      => 'ʻAe wale ʻo Twitch i hoʻokahi kānana i ka manawa.',
    'malformed_parameter'   => 'ʻAʻole pololei ka ʻāpana ":parameter".',
    'bad_identifiers'       => 'ʻAʻole kūpono hoʻokahi a ʻoi aku paha o nā hōʻailona Twitch (ID, inoa komo).',
    'invalid_code'          => 'ʻAʻole kūpono ke kumu ʻae Twitch a ua pau ka manawa.',
    'invalid_refresh_token' => 'ʻAʻole kūpono ka hōʻailona hōʻano hou Twitch: pono ka mea hoʻohana e komo hou.',
    'bad_request'           => 'Ua hōʻole ʻo Twitch i ke noi.',
    'unauthorized'          => 'Ua hōʻole ʻo Twitch i nā palapala hōʻoia.',
    'forbidden'             => 'ʻAʻole ʻae ʻia kēia hana no kēia moʻokāki a i ʻole polokalamu.',
    'not_found'             => 'ʻAʻole i loaʻa iā Twitch kekahi mea no kēia noi.',
    'conflict'              => 'Kūʻē ke noi i ke kūlana o kēia manawa ma Twitch.',
    'gone'                  => 'ʻAʻole loaʻa hou kēia hiʻohiʻona Twitch.',
    'unprocessable'         => 'ʻAʻole hiki iā Twitch ke hana i ke noi.',
    'rate_limited'          => 'Nui loa nā noi i loaʻa iā Twitch. E hoʻāʻo hou ma hope.',
    'server_error'          => 'He pilikia kā Twitch. E hoʻāʻo hou ma hope.',
    'network'               => 'ʻAʻole hiki ke launa me Twitch.',
    'error'                 => 'Ua pane ʻo Twitch me ka hewa.',
];
