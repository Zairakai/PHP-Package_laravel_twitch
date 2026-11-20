<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Le jeton d\'accès Twitch est invalide ou a expiré.',
    'missing_scope'         => 'Il manque une autorisation (scope) au jeton d\'accès Twitch : :scope.',
    'app_token_required'    => 'Ce point d\'accès Twitch n\'accepte qu\'un jeton d\'application.',
    'user_mismatch'         => 'L\'utilisateur n\'est pas le propriétaire du jeton d\'accès.',
    'client_mismatch'       => 'L\'identifiant client Twitch n\'est pas celui qui a créé la ressource ou le jeton.',
    'no_organization'       => 'L\'application Twitch n\'est rattachée à aucune organisation.',
    'multiple_filters'      => 'Twitch n\'accepte qu\'un seul filtre à la fois.',
    'malformed_parameter'   => 'Le paramètre « :parameter » est mal formé.',
    'bad_identifiers'       => 'Un ou plusieurs identifiants Twitch (ID, logins) sont invalides.',
    'invalid_code'          => 'Le code d\'autorisation Twitch est invalide ou a expiré.',
    'invalid_refresh_token' => 'Le jeton de renouvellement Twitch est invalide : l\'utilisateur doit se reconnecter.',
    'bad_request'           => 'Twitch a refusé la requête.',
    'unauthorized'          => 'Twitch a refusé les identifiants.',
    'forbidden'             => 'Cette action n\'est pas autorisée pour ce compte ou cette application.',
    'not_found'             => 'Twitch n\'a rien trouvé pour cette requête.',
    'conflict'              => 'La requête entre en conflit avec l\'état actuel sur Twitch.',
    'gone'                  => 'Cette fonctionnalité de Twitch n\'est plus disponible.',
    'unprocessable'         => 'Twitch n\'a pas pu traiter la requête.',
    'rate_limited'          => 'Twitch a reçu trop de requêtes. Réessayez plus tard.',
    'server_error'          => 'Twitch rencontre un problème. Réessayez plus tard.',
    'network'               => 'Twitch est injoignable.',
    'error'                 => 'Twitch a répondu par une erreur.',
];
