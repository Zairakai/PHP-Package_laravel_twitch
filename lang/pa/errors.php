<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch ਐਕਸੈਸ ਟੋਕਨ ਅਵੈਧ ਹੈ ਜਾਂ ਮਿਆਦ ਪੁੱਗ ਗਈ ਹੈ।',
    'missing_scope'         => 'Twitch ਐਕਸੈਸ ਟੋਕਨ ਵਿੱਚ ਇਜਾਜ਼ਤ (scope) ਨਹੀਂ ਹੈ: :scope।',
    'app_token_required'    => 'ਇਹ Twitch ਐਂਡਪੁਆਇੰਟ ਸਿਰਫ਼ ਐਪ ਐਕਸੈਸ ਟੋਕਨ ਸਵੀਕਾਰ ਕਰਦਾ ਹੈ।',
    'user_mismatch'         => 'ਵਰਤੋਂਕਾਰ ਐਕਸੈਸ ਟੋਕਨ ਦਾ ਮਾਲਕ ਨਹੀਂ ਹੈ।',
    'client_mismatch'       => 'Twitch ਕਲਾਇੰਟ ID ਉਹ ਨਹੀਂ ਹੈ ਜਿਸ ਨੇ ਸਰੋਤ ਜਾਂ ਟੋਕਨ ਬਣਾਇਆ।',
    'no_organization'       => 'Twitch ਐਪਲੀਕੇਸ਼ਨ ਕਿਸੇ ਸੰਸਥਾ ਨਾਲ ਜੁੜੀ ਨਹੀਂ ਹੈ।',
    'multiple_filters'      => 'Twitch ਇੱਕ ਸਮੇਂ ਸਿਰਫ਼ ਇੱਕ ਫਿਲਟਰ ਸਵੀਕਾਰ ਕਰਦਾ ਹੈ।',
    'malformed_parameter'   => 'ਪੈਰਾਮੀਟਰ ":parameter" ਸਹੀ ਢੰਗ ਨਾਲ ਨਹੀਂ ਬਣਿਆ।',
    'bad_identifiers'       => 'ਇੱਕ ਜਾਂ ਵੱਧ Twitch ਪਛਾਣਕਰਤਾ (ID, ਲਾਗਇਨ) ਅਵੈਧ ਹਨ।',
    'invalid_code'          => 'Twitch ਪ੍ਰਮਾਣਿਕਤਾ ਕੋਡ ਅਵੈਧ ਹੈ ਜਾਂ ਮਿਆਦ ਪੁੱਗ ਗਈ ਹੈ।',
    'invalid_refresh_token' => 'Twitch ਰਿਫ੍ਰੈਸ਼ ਟੋਕਨ ਅਵੈਧ ਹੈ: ਵਰਤੋਂਕਾਰ ਨੂੰ ਦੁਬਾਰਾ ਲਾਗਇਨ ਕਰਨਾ ਪਵੇਗਾ।',
    'bad_request'           => 'Twitch ਨੇ ਬੇਨਤੀ ਰੱਦ ਕਰ ਦਿੱਤੀ।',
    'unauthorized'          => 'Twitch ਨੇ ਪ੍ਰਮਾਣ-ਪੱਤਰ ਰੱਦ ਕਰ ਦਿੱਤੇ।',
    'forbidden'             => 'ਇਸ ਖਾਤੇ ਜਾਂ ਐਪਲੀਕੇਸ਼ਨ ਲਈ ਇਹ ਕਾਰਵਾਈ ਮਨਜ਼ੂਰ ਨਹੀਂ ਹੈ।',
    'not_found'             => 'Twitch ਨੂੰ ਇਸ ਬੇਨਤੀ ਲਈ ਕੁਝ ਨਹੀਂ ਮਿਲਿਆ।',
    'conflict'              => 'ਬੇਨਤੀ Twitch ਦੀ ਮੌਜੂਦਾ ਸਥਿਤੀ ਨਾਲ ਟਕਰਾਉਂਦੀ ਹੈ।',
    'gone'                  => 'ਇਹ Twitch ਵਿਸ਼ੇਸ਼ਤਾ ਹੁਣ ਉਪਲਬਧ ਨਹੀਂ ਹੈ।',
    'unprocessable'         => 'Twitch ਬੇਨਤੀ ਦੀ ਪ੍ਰਕਿਰਿਆ ਨਹੀਂ ਕਰ ਸਕਿਆ।',
    'rate_limited'          => 'Twitch ਨੂੰ ਬਹੁਤ ਸਾਰੀਆਂ ਬੇਨਤੀਆਂ ਮਿਲੀਆਂ। ਬਾਅਦ ਵਿੱਚ ਦੁਬਾਰਾ ਕੋਸ਼ਿਸ਼ ਕਰੋ।',
    'server_error'          => 'Twitch ਵਿੱਚ ਸਮੱਸਿਆ ਹੈ। ਬਾਅਦ ਵਿੱਚ ਦੁਬਾਰਾ ਕੋਸ਼ਿਸ਼ ਕਰੋ।',
    'network'               => 'Twitch ਨਾਲ ਸੰਪਰਕ ਨਹੀਂ ਹੋ ਸਕਿਆ।',
    'error'                 => 'Twitch ਨੇ ਗਲਤੀ ਨਾਲ ਜਵਾਬ ਦਿੱਤਾ।',
];
