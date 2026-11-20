<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Token aksés Twitch teu valid atawa geus kadaluwarsa.',
    'missing_scope'         => 'Token aksés Twitch teu boga idin (scope): :scope.',
    'app_token_required'    => 'Titik tungtung Twitch ieu ngan narima token aksés aplikasi.',
    'user_mismatch'         => 'Pamaké lain nu boga token aksés.',
    'client_mismatch'       => 'ID klien Twitch lain anu nyieun sumber daya atawa token.',
    'no_organization'       => 'Aplikasi Twitch teu dihubungkeun ka organisasi.',
    'multiple_filters'      => 'Twitch ngan narima hiji panyaring dina hiji waktu.',
    'malformed_parameter'   => 'Parameter ":parameter" teu kabentuk bener.',
    'bad_identifiers'       => 'Hiji atawa leuwih idéntifikasi Twitch (ID, login) teu valid.',
    'invalid_code'          => 'Kode otorisasi Twitch teu valid atawa geus kadaluwarsa.',
    'invalid_refresh_token' => 'Token nyegerkeun Twitch teu valid: pamaké kudu lebet deui.',
    'bad_request'           => 'Twitch nolak pamundut.',
    'unauthorized'          => 'Twitch nolak kredensial.',
    'forbidden'             => 'Tindakan ieu teu diwenangkeun pikeun akun atawa aplikasi ieu.',
    'not_found'             => 'Twitch teu manggihan nanaon pikeun pamundut ieu.',
    'conflict'              => 'Pamundut ieu bentrok jeung kaayaan ayeuna di Twitch.',
    'gone'                  => 'Fitur Twitch ieu geus teu sadia deui.',
    'unprocessable'         => 'Twitch teu bisa ngolah pamundut.',
    'rate_limited'          => 'Twitch narima loba teuing pamundut. Cobaan deui engké.',
    'server_error'          => 'Twitch boga masalah. Cobaan deui engké.',
    'network'               => 'Twitch teu bisa dihontal.',
    'error'                 => 'Twitch ngajawab ku kasalahan.',
];
