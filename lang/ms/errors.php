<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Token akses Twitch tidak sah atau telah tamat tempoh.',
    'missing_scope'         => 'Token akses Twitch tiada kebenaran (scope): :scope.',
    'app_token_required'    => 'Titik akhir Twitch ini hanya menerima token akses aplikasi.',
    'user_mismatch'         => 'Pengguna bukan pemilik token akses.',
    'client_mismatch'       => 'ID klien Twitch bukan yang mencipta sumber atau token.',
    'no_organization'       => 'Aplikasi Twitch tidak dipautkan kepada organisasi.',
    'multiple_filters'      => 'Twitch hanya menerima satu penapis pada satu masa.',
    'malformed_parameter'   => 'Parameter ":parameter" tidak dibentuk dengan betul.',
    'bad_identifiers'       => 'Satu atau lebih pengecam Twitch (ID, log masuk) tidak sah.',
    'invalid_code'          => 'Kod kebenaran Twitch tidak sah atau telah tamat tempoh.',
    'invalid_refresh_token' => 'Token muat semula Twitch tidak sah: pengguna mesti log masuk semula.',
    'bad_request'           => 'Twitch menolak permintaan.',
    'unauthorized'          => 'Twitch menolak bukti kelayakan.',
    'forbidden'             => 'Tindakan ini tidak dibenarkan untuk akaun atau aplikasi ini.',
    'not_found'             => 'Twitch tidak menemui apa-apa untuk permintaan ini.',
    'conflict'              => 'Permintaan bercanggah dengan keadaan semasa di Twitch.',
    'gone'                  => 'Ciri Twitch ini tidak lagi tersedia.',
    'unprocessable'         => 'Twitch tidak dapat memproses permintaan.',
    'rate_limited'          => 'Twitch menerima terlalu banyak permintaan. Cuba lagi kemudian.',
    'server_error'          => 'Twitch menghadapi masalah. Cuba lagi kemudian.',
    'network'               => 'Twitch tidak dapat dihubungi.',
    'error'                 => 'Twitch menjawab dengan ralat.',
];
