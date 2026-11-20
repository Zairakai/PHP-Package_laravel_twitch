<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch kirish tokeni yaroqsiz yoki muddati tugagan.',
    'missing_scope'         => 'Twitch kirish tokenida ruxsat (scope) yo‘q: :scope.',
    'app_token_required'    => 'Bu Twitch yakuniy nuqtasi faqat ilova kirish tokenini qabul qiladi.',
    'user_mismatch'         => 'Foydalanuvchi kirish tokenining egasi emas.',
    'client_mismatch'       => 'Twitch mijoz ID si resurs yoki tokenni yaratgan ID emas.',
    'no_organization'       => 'Twitch ilovasi tashkilotga bog‘lanmagan.',
    'multiple_filters'      => 'Twitch bir vaqtda faqat bitta filtrni qabul qiladi.',
    'malformed_parameter'   => '«:parameter» parametri noto‘g‘ri tuzilgan.',
    'bad_identifiers'       => 'Twitch identifikatorlaridan biri yoki bir nechasi (ID, loginlar) yaroqsiz.',
    'invalid_code'          => 'Twitch avtorizatsiya kodi yaroqsiz yoki muddati tugagan.',
    'invalid_refresh_token' => 'Twitch yangilash tokeni yaroqsiz: foydalanuvchi qayta kirishi kerak.',
    'bad_request'           => 'Twitch so‘rovni rad etdi.',
    'unauthorized'          => 'Twitch ma’lumotlarni rad etdi.',
    'forbidden'             => 'Bu amal ushbu hisob yoki ilova uchun ruxsat etilmagan.',
    'not_found'             => 'Twitch bu so‘rov bo‘yicha hech narsa topmadi.',
    'conflict'              => 'So‘rov Twitch dagi joriy holat bilan zid.',
    'gone'                  => 'Twitch ning bu funksiyasi endi mavjud emas.',
    'unprocessable'         => 'Twitch so‘rovni qayta ishlay olmadi.',
    'rate_limited'          => 'Twitch juda ko‘p so‘rov oldi. Keyinroq qayta urinib ko‘ring.',
    'server_error'          => 'Twitch da muammo bor. Keyinroq qayta urinib ko‘ring.',
    'network'               => 'Twitch bilan bog‘lanib bo‘lmadi.',
    'error'                 => 'Twitch xato bilan javob berdi.',
];
