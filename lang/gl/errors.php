<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'O token de acceso de Twitch non é válido ou caducou.',
    'missing_scope'         => 'Ao token de acceso de Twitch fáltalle un permiso (scope): :scope.',
    'app_token_required'    => 'Este punto final de Twitch só acepta un token de aplicación.',
    'user_mismatch'         => 'O usuario non é o propietario do token de acceso.',
    'client_mismatch'       => 'O ID de cliente de Twitch non é o que creou o recurso ou o token.',
    'no_organization'       => 'A aplicación de Twitch non está vinculada a ningunha organización.',
    'multiple_filters'      => 'Twitch só acepta un filtro á vez.',
    'malformed_parameter'   => 'O parámetro «:parameter» non está ben formado.',
    'bad_identifiers'       => 'Un ou máis identificadores de Twitch (ID, nomes de usuario) non son válidos.',
    'invalid_code'          => 'O código de autorización de Twitch non é válido ou caducou.',
    'invalid_refresh_token' => 'O token de actualización de Twitch non é válido: o usuario debe iniciar sesión de novo.',
    'bad_request'           => 'Twitch rexeitou a solicitude.',
    'unauthorized'          => 'Twitch rexeitou as credenciais.',
    'forbidden'             => 'Esta acción non está permitida para esta conta ou esta aplicación.',
    'not_found'             => 'Twitch non atopou nada para esta solicitude.',
    'conflict'              => 'A solicitude entra en conflito co estado actual en Twitch.',
    'gone'                  => 'Esta función de Twitch xa non está dispoñible.',
    'unprocessable'         => 'Twitch non puido procesar a solicitude.',
    'rate_limited'          => 'Twitch recibiu demasiadas solicitudes. Téntao de novo máis tarde.',
    'server_error'          => 'Twitch ten un problema. Téntao de novo máis tarde.',
    'network'               => 'Non se puido contactar con Twitch.',
    'error'                 => 'Twitch respondeu cun erro.',
];
