<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch ꯑꯦꯛꯁꯦꯁ ꯇꯣꯀꯦꯟ ꯑꯁꯤ ꯂꯦꯞꯇꯕꯅꯤ ꯅꯠꯇꯅ ꯃꯇꯝ ꯂꯣꯏꯔꯦ꯫',
    'missing_scope'         => 'Twitch ꯑꯦꯛꯁꯦꯁ ꯇꯣꯀꯦꯟꯗ ꯌꯥꯕꯥ (scope) ꯂꯩꯇꯦ: :scope꯫',
    'app_token_required'    => 'Twitch ꯑꯦꯟꯗꯄꯣꯏꯟꯇ ꯑꯁꯤꯅ ꯑꯦꯞ ꯑꯦꯛꯁꯦꯁ ꯇꯣꯀꯦꯟ ꯈꯛꯇꯅꯨ ꯑꯣꯢꯅꯥ ꯂꯧꯏ꯫',
    'user_mismatch'         => 'ꯆꯨꯞꯄꯥ ꯑꯁꯤ ꯑꯦꯛꯁꯦꯁ ꯇꯣꯀꯦꯟꯒꯤ ꯃꯄꯨ ꯅꯠꯇꯦ꯫',
    'client_mismatch'       => 'Twitch ꯀ꯭ꯂꯥꯏꯑꯦꯟꯇ ID ꯑꯁꯤ ꯔꯤꯁꯣꯔꯁ ꯅꯠꯇꯅ ꯇꯣꯀꯦꯟ ꯁꯦꯝꯕꯥ ꯅꯠꯇꯦ꯫',
    'no_organization'       => 'Twitch ꯑꯦꯞꯂꯤꯀꯦꯁꯟ ꯑꯁꯤ ꯑꯣꯔꯒꯦꯅꯥꯏꯖꯦꯁꯅꯒꯥ ꯆꯥꯎꯈꯠꯂꯤꯇꯦ꯫',
    'multiple_filters'      => 'Twitch ꯅꯥ ꯃꯇꯝ ꯑꯃꯗ ꯐꯤꯂꯇꯔ ꯑꯃꯈꯛ ꯂꯧꯏ꯫',
    'malformed_parameter'   => 'ꯄꯦꯔꯥꯃꯤꯇꯔ ":parameter" ꯑꯁꯤ ꯆꯨꯝꯅ ꯁꯦꯝꯕꯥ ꯅꯠꯇꯦ꯫',
    'bad_identifiers'       => 'Twitch ꯄꯥꯎꯖꯦꯟ ꯑꯃꯅꯠꯇꯅ ꯍꯦꯟꯅ (ID, ꯂꯣꯒꯤꯟ) ꯌꯥꯎꯕꯥ ꯅꯠꯇꯦ꯫',
    'invalid_code'          => 'Twitch ꯑꯣꯊꯣꯔꯥꯏꯖꯦꯁꯟ ꯀꯣꯗ ꯑꯁꯤ ꯂꯦꯞꯇꯕꯅꯤ ꯅꯠꯇꯅ ꯃꯇꯝ ꯂꯣꯏꯔꯦ꯫',
    'invalid_refresh_token' => 'Twitch ꯔꯤꯐ꯭ꯔꯦꯁ ꯇꯣꯀꯦꯟ ꯑꯁꯤ ꯂꯦꯞꯇꯕꯅꯤ: ꯆꯨꯞꯄꯥꯅ ꯍꯟꯅꯥ ꯂꯣꯒꯤꯟ ꯇꯧꯒꯗꯕꯅꯤ꯫',
    'bad_request'           => 'Twitch ꯅꯥ ꯍꯥꯌꯖꯕꯥ ꯑꯁꯤ ꯌꯥꯗꯦ꯫',
    'unauthorized'          => 'Twitch ꯅꯥ ꯀ꯭ꯔꯦꯗꯦꯟꯁꯤꯌꯥꯜ ꯌꯥꯗꯦ꯫',
    'forbidden'             => 'ꯃꯁꯤꯒꯤ ꯑꯦꯀꯥꯎꯟꯇ ꯅꯠꯇꯅ ꯑꯦꯞꯂꯤꯀꯦꯁꯅꯒꯤꯗꯃꯛ ꯊꯕꯛ ꯑꯁꯤ ꯌꯥꯗꯦ꯫',
    'not_found'             => 'Twitch ꯅꯥ ꯍꯥꯌꯖꯕꯥ ꯑꯁꯤꯒꯤꯗꯃꯛ ꯀꯔꯤꯁꯨ ꯃꯪꯗꯦ꯫',
    'conflict'              => 'ꯍꯥꯌꯖꯕꯥ ꯑꯁꯤ Twitch ꯗꯥ ꯍꯧꯖꯤꯛꯀꯤ ꯐꯤꯕꯥꯒꯥ ꯂꯥꯟꯅꯔꯤ꯫',
    'gone'                  => 'Twitch ꯐꯤꯆꯔ ꯑꯁꯤ ꯍꯧꯖꯤꯛ ꯂꯩꯇꯦ꯫',
    'unprocessable'         => 'Twitch ꯅꯥ ꯍꯥꯌꯖꯕꯥ ꯑꯁꯤ ꯄ꯭ꯔꯣꯁꯦꯁ ꯇꯧꯕꯥ ꯉꯃꯗꯦ꯫',
    'rate_limited'          => 'Twitch ꯗꯥ ꯍꯥꯌꯖꯕꯥ ꯀꯌꯥ ꯂꯥꯀꯈꯤ꯫ ꯃꯇꯨꯡꯗ ꯑꯃꯨꯛ ꯍꯟꯅꯥ ꯇꯥꯕꯤꯌꯨ꯫',
    'server_error'          => 'Twitch ꯗꯥ ꯀꯤꯠꯄꯥ ꯂꯩ꯫ ꯃꯇꯨꯡꯗ ꯑꯃꯨꯛ ꯍꯟꯅꯥ ꯇꯥꯕꯤꯌꯨ꯫',
    'network'               => 'Twitch ꯗꯥ ꯌꯧꯍꯟꯕꯥ ꯉꯃꯗꯦ꯫',
    'error'                 => 'Twitch ꯅꯥ ꯑꯁꯣꯏꯕꯥ ꯑꯃꯒꯥ ꯂꯣꯌꯅ ꯄꯥꯎꯈꯨꯝ ꯄꯤꯈꯤ꯫',
];
