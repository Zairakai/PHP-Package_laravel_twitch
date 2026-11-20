<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'رمز الوصول إلى Twitch غير صالح أو منتهي الصلاحية.',
    'missing_scope'         => 'رمز الوصول إلى Twitch يفتقر إلى صلاحية (scope): :scope.',
    'app_token_required'    => 'نقطة النهاية هذه في Twitch تقبل رمز التطبيق فقط.',
    'user_mismatch'         => 'المستخدم ليس مالك رمز الوصول.',
    'client_mismatch'       => 'معرّف عميل Twitch ليس المعرّف الذي أنشأ المورد أو الرمز.',
    'no_organization'       => 'تطبيق Twitch غير مرتبط بمؤسسة.',
    'multiple_filters'      => 'يقبل Twitch مرشحًا واحدًا فقط في كل مرة.',
    'malformed_parameter'   => 'المعامل «:parameter» غير صحيح الصياغة.',
    'bad_identifiers'       => 'معرّف واحد أو أكثر من معرّفات Twitch (المعرّفات، أسماء الدخول) غير صالح.',
    'invalid_code'          => 'رمز تفويض Twitch غير صالح أو منتهي الصلاحية.',
    'invalid_refresh_token' => 'رمز التحديث في Twitch غير صالح: يجب على المستخدم تسجيل الدخول مجددًا.',
    'bad_request'           => 'رفض Twitch الطلب.',
    'unauthorized'          => 'رفض Twitch بيانات الاعتماد.',
    'forbidden'             => 'هذا الإجراء غير مسموح به لهذا الحساب أو هذا التطبيق.',
    'not_found'             => 'لم يجد Twitch شيئًا لهذا الطلب.',
    'conflict'              => 'يتعارض الطلب مع الحالة الحالية على Twitch.',
    'gone'                  => 'لم تعد ميزة Twitch هذه متاحة.',
    'unprocessable'         => 'تعذّر على Twitch معالجة الطلب.',
    'rate_limited'          => 'تلقى Twitch عددًا كبيرًا جدًا من الطلبات. حاول مرة أخرى لاحقًا.',
    'server_error'          => 'يواجه Twitch مشكلة. حاول مرة أخرى لاحقًا.',
    'network'               => 'تعذّر الوصول إلى Twitch.',
    'error'                 => 'ردّ Twitch بخطأ.',
];
