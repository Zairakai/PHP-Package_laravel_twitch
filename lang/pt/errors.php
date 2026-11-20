<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'O token de acesso do Twitch é inválido ou expirou.',
    'missing_scope'         => 'O token de acesso do Twitch não tem uma permissão (scope): :scope.',
    'app_token_required'    => 'Este ponto de acesso do Twitch aceita apenas um token de aplicação.',
    'user_mismatch'         => 'O utilizador não é o proprietário do token de acesso.',
    'client_mismatch'       => 'O ID de cliente do Twitch não é o que criou o recurso ou o token.',
    'no_organization'       => 'A aplicação do Twitch não está associada a uma organização.',
    'multiple_filters'      => 'O Twitch aceita apenas um filtro de cada vez.',
    'malformed_parameter'   => 'O parâmetro «:parameter» está mal formado.',
    'bad_identifiers'       => 'Um ou mais identificadores do Twitch (IDs, logins) são inválidos.',
    'invalid_code'          => 'O código de autorização do Twitch é inválido ou expirou.',
    'invalid_refresh_token' => 'O token de atualização do Twitch é inválido: o utilizador tem de iniciar sessão novamente.',
    'bad_request'           => 'O Twitch recusou o pedido.',
    'unauthorized'          => 'O Twitch recusou as credenciais.',
    'forbidden'             => 'Esta ação não é permitida para esta conta ou esta aplicação.',
    'not_found'             => 'O Twitch não encontrou nada para este pedido.',
    'conflict'              => 'O pedido entra em conflito com o estado atual no Twitch.',
    'gone'                  => 'Esta funcionalidade do Twitch já não está disponível.',
    'unprocessable'         => 'O Twitch não conseguiu processar o pedido.',
    'rate_limited'          => 'O Twitch recebeu demasiados pedidos. Tente novamente mais tarde.',
    'server_error'          => 'O Twitch está com um problema. Tente novamente mais tarde.',
    'network'               => 'Não foi possível contactar o Twitch.',
    'error'                 => 'O Twitch respondeu com um erro.',
];
