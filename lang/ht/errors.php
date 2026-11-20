<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Token aksè Twitch la pa valab oswa li ekspire.',
    'missing_scope'         => 'Token aksè Twitch la manke yon pèmisyon (scope): :scope.',
    'app_token_required'    => 'Pwen final Twitch sa a aksepte sèlman yon token aksè aplikasyon.',
    'user_mismatch'         => 'Itilizatè a pa pwopriyetè token aksè a.',
    'client_mismatch'       => 'ID kliyan Twitch la pa sa ki te kreye resous la oswa token an.',
    'no_organization'       => 'Aplikasyon Twitch la pa konekte ak yon òganizasyon.',
    'multiple_filters'      => 'Twitch aksepte sèlman yon sèl filt alafwa.',
    'malformed_parameter'   => 'Paramèt ":parameter" lan pa byen fòme.',
    'bad_identifiers'       => 'Youn oswa plizyè idantifyan Twitch (ID, non koneksyon) pa valab.',
    'invalid_code'          => 'Kòd otorizasyon Twitch la pa valab oswa li ekspire.',
    'invalid_refresh_token' => 'Token rafrechisman Twitch la pa valab: itilizatè a dwe konekte ankò.',
    'bad_request'           => 'Twitch refize demann lan.',
    'unauthorized'          => 'Twitch refize idantifyan yo.',
    'forbidden'             => 'Aksyon sa a pa otorize pou kont sa a oswa aplikasyon sa a.',
    'not_found'             => 'Twitch pa jwenn anyen pou demann sa a.',
    'conflict'              => 'Demann lan an konfli ak eta aktyèl la sou Twitch.',
    'gone'                  => 'Fonksyon Twitch sa a pa disponib ankò.',
    'unprocessable'         => 'Twitch pa t kapab trete demann lan.',
    'rate_limited'          => 'Twitch resevwa twòp demann. Eseye ankò pita.',
    'server_error'          => 'Twitch gen yon pwoblèm. Eseye ankò pita.',
    'network'               => 'Pa t posib pou kontakte Twitch.',
    'error'                 => 'Twitch reponn ak yon erè.',
];
