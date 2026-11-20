<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch giriş tokeni etibarsızdır və ya müddəti bitib.',
    'missing_scope'         => 'Twitch giriş tokeninin icazəsi (scope) çatışmır: :scope.',
    'app_token_required'    => 'Bu Twitch son nöqtəsi yalnız tətbiq giriş tokenini qəbul edir.',
    'user_mismatch'         => 'İstifadəçi giriş tokeninin sahibi deyil.',
    'client_mismatch'       => 'Twitch müştəri ID-si resursu və ya tokeni yaradan ID deyil.',
    'no_organization'       => 'Twitch tətbiqi heç bir təşkilata bağlı deyil.',
    'multiple_filters'      => 'Twitch eyni anda yalnız bir filtr qəbul edir.',
    'malformed_parameter'   => '":parameter" parametri düzgün formalaşdırılmayıb.',
    'bad_identifiers'       => 'Bir və ya bir neçə Twitch identifikatoru (ID, giriş adı) etibarsızdır.',
    'invalid_code'          => 'Twitch avtorizasiya kodu etibarsızdır və ya müddəti bitib.',
    'invalid_refresh_token' => 'Twitch yeniləmə tokeni etibarsızdır: istifadəçi yenidən daxil olmalıdır.',
    'bad_request'           => 'Twitch sorğunu rədd etdi.',
    'unauthorized'          => 'Twitch giriş məlumatlarını rədd etdi.',
    'forbidden'             => 'Bu əməliyyata bu hesab və ya tətbiq üçün icazə verilmir.',
    'not_found'             => 'Twitch bu sorğu üçün heç nə tapmadı.',
    'conflict'              => 'Sorğu Twitch-dəki cari vəziyyətlə ziddiyyət təşkil edir.',
    'gone'                  => 'Bu Twitch funksiyası artıq mövcud deyil.',
    'unprocessable'         => 'Twitch sorğunu emal edə bilmədi.',
    'rate_limited'          => 'Twitch çox sayda sorğu aldı. Sonra yenidən cəhd edin.',
    'server_error'          => 'Twitch-də problem var. Sonra yenidən cəhd edin.',
    'network'               => 'Twitch-ə qoşulmaq mümkün olmadı.',
    'error'                 => 'Twitch xəta ilə cavab verdi.',
];
