<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'El testimoni d\'accés de Twitch no és vàlid o ha caducat.',
    'missing_scope'         => 'Al testimoni d\'accés de Twitch li falta un permís (scope): :scope.',
    'app_token_required'    => 'Aquest punt final de Twitch només accepta un testimoni d\'aplicació.',
    'user_mismatch'         => 'L\'usuari no és el propietari del testimoni d\'accés.',
    'client_mismatch'       => 'L\'ID de client de Twitch no és el que va crear el recurs o el testimoni.',
    'no_organization'       => 'L\'aplicació de Twitch no està vinculada a cap organització.',
    'multiple_filters'      => 'Twitch només accepta un filtre alhora.',
    'malformed_parameter'   => 'El paràmetre «:parameter» no està ben format.',
    'bad_identifiers'       => 'Un o més identificadors de Twitch (ID, noms d\'usuari) no són vàlids.',
    'invalid_code'          => 'El codi d\'autorització de Twitch no és vàlid o ha caducat.',
    'invalid_refresh_token' => 'El testimoni d\'actualització de Twitch no és vàlid: l\'usuari ha de tornar a iniciar la sessió.',
    'bad_request'           => 'Twitch ha rebutjat la sol·licitud.',
    'unauthorized'          => 'Twitch ha rebutjat les credencials.',
    'forbidden'             => 'Aquesta acció no està permesa per a aquest compte o aquesta aplicació.',
    'not_found'             => 'Twitch no ha trobat res per a aquesta sol·licitud.',
    'conflict'              => 'La sol·licitud entra en conflicte amb l\'estat actual a Twitch.',
    'gone'                  => 'Aquesta funció de Twitch ja no està disponible.',
    'unprocessable'         => 'Twitch no ha pogut processar la sol·licitud.',
    'rate_limited'          => 'Twitch ha rebut massa sol·licituds. Torna-ho a provar més tard.',
    'server_error'          => 'Twitch té un problema. Torna-ho a provar més tard.',
    'network'               => 'No s\'ha pogut contactar amb Twitch.',
    'error'                 => 'Twitch ha respost amb un error.',
];
