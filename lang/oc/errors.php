<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Lo geton d\'accès Twitch es invalid o a expirat.',
    'missing_scope'         => 'Al geton d\'accès Twitch li manca una autorizacion (scope) : :scope.',
    'app_token_required'    => 'Aqueste punt d\'accès Twitch accepta pas qu\'un geton d\'aplicacion.',
    'user_mismatch'         => 'L\'utilizaire es pas lo proprietari del geton d\'accès.',
    'client_mismatch'       => 'L\'ID de client Twitch es pas aquel que ten creat la ressorsa o lo geton.',
    'no_organization'       => 'L\'aplicacion Twitch es pas ligada a una organizacion.',
    'multiple_filters'      => 'Twitch accepta pas qu\'un sol filtre a l\'encòp.',
    'malformed_parameter'   => 'Lo paramètre « :parameter » es mal format.',
    'bad_identifiers'       => 'Un o mantun identificant Twitch (ID, identificants de connexion) son invalids.',
    'invalid_code'          => 'Lo còde d\'autorizacion Twitch es invalid o a expirat.',
    'invalid_refresh_token' => 'Lo geton de refrescament Twitch es invalid : l\'utilizaire se deu tornar connectar.',
    'bad_request'           => 'Twitch a refusat la demanda.',
    'unauthorized'          => 'Twitch a refusat los identificants.',
    'forbidden'             => 'Aquesta accion es pas autorizada per aqueste compte o aquesta aplicacion.',
    'not_found'             => 'Twitch a pas trobat res per aquesta demanda.',
    'conflict'              => 'La demanda es en conflicte amb l\'estat actual sus Twitch.',
    'gone'                  => 'Aquesta foncionalitat de Twitch es pas mai disponibla.',
    'unprocessable'         => 'Twitch a pas pogut tractar la demanda.',
    'rate_limited'          => 'Twitch a recebut tròp de demandas. Tornatz ensajar mai tard.',
    'server_error'          => 'Twitch a un problèma. Tornatz ensajar mai tard.',
    'network'               => 'Impossible de contactar Twitch.',
    'error'                 => 'Twitch a respondut amb una error.',
];
