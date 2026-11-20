<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'El token de acceso de Twitch no es válido o ha caducado.',
    'missing_scope'         => 'Al token de acceso de Twitch le falta un permiso (scope): :scope.',
    'app_token_required'    => 'Este punto de acceso de Twitch solo acepta un token de aplicación.',
    'user_mismatch'         => 'El usuario no es el propietario del token de acceso.',
    'client_mismatch'       => 'El ID de cliente de Twitch no es el que creó el recurso o el token.',
    'no_organization'       => 'La aplicación de Twitch no está vinculada a una organización.',
    'multiple_filters'      => 'Twitch solo acepta un filtro a la vez.',
    'malformed_parameter'   => 'El parámetro «:parameter» no está bien formado.',
    'bad_identifiers'       => 'Uno o más identificadores de Twitch (ID, logins) no son válidos.',
    'invalid_code'          => 'El código de autorización de Twitch no es válido o ha caducado.',
    'invalid_refresh_token' => 'El token de actualización de Twitch no es válido: el usuario debe volver a conectarse.',
    'bad_request'           => 'Twitch rechazó la solicitud.',
    'unauthorized'          => 'Twitch rechazó las credenciales.',
    'forbidden'             => 'Esta acción no está permitida para esta cuenta o esta aplicación.',
    'not_found'             => 'Twitch no encontró nada para esta solicitud.',
    'conflict'              => 'La solicitud entra en conflicto con el estado actual en Twitch.',
    'gone'                  => 'Esta función de Twitch ya no está disponible.',
    'unprocessable'         => 'Twitch no pudo procesar la solicitud.',
    'rate_limited'          => 'Twitch recibió demasiadas solicitudes. Inténtalo de nuevo más tarde.',
    'server_error'          => 'Twitch tiene un problema. Inténtalo de nuevo más tarde.',
    'network'               => 'No se pudo contactar con Twitch.',
    'error'                 => 'Twitch respondió con un error.',
];
