<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch erişim belirteci geçersiz veya süresi dolmuş.',
    'missing_scope'         => 'Twitch erişim belirtecinde bir izin (scope) eksik: :scope.',
    'app_token_required'    => 'Bu Twitch uç noktası yalnızca bir uygulama erişim belirteci kabul eder.',
    'user_mismatch'         => 'Kullanıcı, erişim belirtecinin sahibi değil.',
    'client_mismatch'       => 'Twitch istemci kimliği, kaynağı veya belirteci oluşturan kimlik değil.',
    'no_organization'       => 'Twitch uygulaması bir kuruluşa bağlı değil.',
    'multiple_filters'      => 'Twitch aynı anda yalnızca bir filtre kabul eder.',
    'malformed_parameter'   => '":parameter" parametresi hatalı biçimlendirilmiş.',
    'bad_identifiers'       => 'Bir veya daha fazla Twitch tanımlayıcısı (kimlikler, kullanıcı adları) geçersiz.',
    'invalid_code'          => 'Twitch yetkilendirme kodu geçersiz veya süresi dolmuş.',
    'invalid_refresh_token' => 'Twitch yenileme belirteci geçersiz: kullanıcının yeniden bağlanması gerekir.',
    'bad_request'           => 'Twitch isteği reddetti.',
    'unauthorized'          => 'Twitch kimlik bilgilerini reddetti.',
    'forbidden'             => 'Bu işlem bu hesap veya bu uygulama için izin verilmiyor.',
    'not_found'             => 'Twitch bu istek için hiçbir şey bulamadı.',
    'conflict'              => 'İstek, Twitch\'teki mevcut durumla çelişiyor.',
    'gone'                  => 'Bu Twitch özelliği artık kullanılamıyor.',
    'unprocessable'         => 'Twitch isteği işleyemedi.',
    'rate_limited'          => 'Twitch çok fazla istek aldı. Daha sonra tekrar deneyin.',
    'server_error'          => 'Twitch\'te bir sorun var. Daha sonra tekrar deneyin.',
    'network'               => 'Twitch\'e ulaşılamadı.',
    'error'                 => 'Twitch bir hatayla yanıt verdi.',
];
