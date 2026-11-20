<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch رسائی ٹوکن غلط ہے یا اس کی میعاد ختم ہو گئی ہے۔',
    'missing_scope'         => 'Twitch رسائی ٹوکن میں اجازت (scope) نہیں ہے: :scope۔',
    'app_token_required'    => 'یہ Twitch اینڈ پوائنٹ صرف ایپ رسائی ٹوکن قبول کرتا ہے۔',
    'user_mismatch'         => 'صارف رسائی ٹوکن کا مالک نہیں ہے۔',
    'client_mismatch'       => 'Twitch کلائنٹ ID وہ نہیں ہے جس نے وسیلہ یا ٹوکن بنایا۔',
    'no_organization'       => 'Twitch ایپلیکیشن کسی تنظیم سے منسلک نہیں ہے۔',
    'multiple_filters'      => 'Twitch ایک وقت میں صرف ایک فلٹر قبول کرتا ہے۔',
    'malformed_parameter'   => 'پیرامیٹر ":parameter" درست طریقے سے نہیں بنایا گیا۔',
    'bad_identifiers'       => 'ایک یا زیادہ Twitch شناخت کنندگان (ID، لاگ ان) غلط ہیں۔',
    'invalid_code'          => 'Twitch اجازت کوڈ غلط ہے یا اس کی میعاد ختم ہو گئی ہے۔',
    'invalid_refresh_token' => 'Twitch ریفریش ٹوکن غلط ہے: صارف کو دوبارہ لاگ ان کرنا ہوگا۔',
    'bad_request'           => 'Twitch نے درخواست مسترد کر دی۔',
    'unauthorized'          => 'Twitch نے اسناد مسترد کر دیں۔',
    'forbidden'             => 'اس اکاؤنٹ یا ایپلیکیشن کے لیے یہ عمل اجازت یافتہ نہیں ہے۔',
    'not_found'             => 'Twitch کو اس درخواست کے لیے کچھ نہیں ملا۔',
    'conflict'              => 'درخواست Twitch کی موجودہ حالت سے متصادم ہے۔',
    'gone'                  => 'یہ Twitch خصوصیت اب دستیاب نہیں ہے۔',
    'unprocessable'         => 'Twitch درخواست پر عمل نہیں کر سکا۔',
    'rate_limited'          => 'Twitch کو بہت زیادہ درخواستیں موصول ہوئیں۔ بعد میں دوبارہ کوشش کریں۔',
    'server_error'          => 'Twitch میں مسئلہ ہے۔ بعد میں دوبارہ کوشش کریں۔',
    'network'               => 'Twitch سے رابطہ نہیں ہو سکا۔',
    'error'                 => 'Twitch نے غلطی کے ساتھ جواب دیا۔',
];
