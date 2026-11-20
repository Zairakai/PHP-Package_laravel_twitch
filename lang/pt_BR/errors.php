<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'O token de acesso do Twitch é inválido ou expirou.',
    'missing_scope'         => 'O token de acesso do Twitch não tem uma permissão (scope): :scope.',
    'app_token_required'    => 'Este endpoint do Twitch aceita apenas um token de acesso de aplicativo.',
    'user_mismatch'         => 'O usuário não é o proprietário do token de acesso.',
    'client_mismatch'       => 'O ID de cliente do Twitch não é o que criou o recurso ou o token.',
    'no_organization'       => 'O aplicativo do Twitch não está vinculado a uma organização.',
    'multiple_filters'      => 'O Twitch aceita apenas um filtro por vez.',
    'malformed_parameter'   => 'O parâmetro ":parameter" está malformado.',
    'bad_identifiers'       => 'Um ou mais identificadores do Twitch (IDs, logins) são inválidos.',
    'invalid_code'          => 'O código de autorização do Twitch é inválido ou expirou.',
    'invalid_refresh_token' => 'O token de atualização do Twitch é inválido: o usuário precisa entrar novamente.',
    'bad_request'           => 'O Twitch recusou a solicitação.',
    'unauthorized'          => 'O Twitch recusou as credenciais.',
    'forbidden'             => 'Esta ação não é permitida para esta conta ou este aplicativo.',
    'not_found'             => 'O Twitch não encontrou nada para esta solicitação.',
    'conflict'              => 'A solicitação entra em conflito com o estado atual no Twitch.',
    'gone'                  => 'Este recurso do Twitch não está mais disponível.',
    'unprocessable'         => 'O Twitch não conseguiu processar a solicitação.',
    'rate_limited'          => 'O Twitch recebeu solicitações demais. Tente novamente mais tarde.',
    'server_error'          => 'O Twitch está com um problema. Tente novamente mais tarde.',
    'network'               => 'Não foi possível entrar em contato com o Twitch.',
    'error'                 => 'O Twitch respondeu com um erro.',
];
