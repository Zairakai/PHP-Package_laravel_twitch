<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Token akses Twitch tidak valid atau telah kedaluwarsa.',
    'missing_scope'         => 'Token akses Twitch tidak memiliki izin (scope): :scope.',
    'app_token_required'    => 'Endpoint Twitch ini hanya menerima token akses aplikasi.',
    'user_mismatch'         => 'Pengguna bukan pemilik token akses.',
    'client_mismatch'       => 'ID klien Twitch bukan yang membuat sumber daya atau token.',
    'no_organization'       => 'Aplikasi Twitch tidak terhubung ke organisasi.',
    'multiple_filters'      => 'Twitch hanya menerima satu filter dalam satu waktu.',
    'malformed_parameter'   => 'Parameter ":parameter" tidak terbentuk dengan benar.',
    'bad_identifiers'       => 'Satu atau lebih pengenal Twitch (ID, login) tidak valid.',
    'invalid_code'          => 'Kode otorisasi Twitch tidak valid atau telah kedaluwarsa.',
    'invalid_refresh_token' => 'Token penyegaran Twitch tidak valid: pengguna harus masuk lagi.',
    'bad_request'           => 'Twitch menolak permintaan.',
    'unauthorized'          => 'Twitch menolak kredensial.',
    'forbidden'             => 'Tindakan ini tidak diizinkan untuk akun atau aplikasi ini.',
    'not_found'             => 'Twitch tidak menemukan apa pun untuk permintaan ini.',
    'conflict'              => 'Permintaan bertentangan dengan kondisi saat ini di Twitch.',
    'gone'                  => 'Fitur Twitch ini tidak lagi tersedia.',
    'unprocessable'         => 'Twitch tidak dapat memproses permintaan.',
    'rate_limited'          => 'Twitch menerima terlalu banyak permintaan. Coba lagi nanti.',
    'server_error'          => 'Twitch sedang bermasalah. Coba lagi nanti.',
    'network'               => 'Twitch tidak dapat dihubungi.',
    'error'                 => 'Twitch menjawab dengan kesalahan.',
];
