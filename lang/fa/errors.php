<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'توکن دسترسی Twitch نامعتبر است یا منقضی شده است.',
    'missing_scope'         => 'توکن دسترسی Twitch فاقد یک مجوز (scope) است: :scope.',
    'app_token_required'    => 'این نقطه پایانی Twitch فقط توکن دسترسی برنامه را می‌پذیرد.',
    'user_mismatch'         => 'کاربر مالک توکن دسترسی نیست.',
    'client_mismatch'       => 'شناسه کلاینت Twitch همان شناسه‌ای نیست که منبع یا توکن را ایجاد کرده است.',
    'no_organization'       => 'برنامه Twitch به هیچ سازمانی متصل نیست.',
    'multiple_filters'      => 'Twitch در هر زمان فقط یک فیلتر می‌پذیرد.',
    'malformed_parameter'   => 'پارامتر «:parameter» به درستی تشکیل نشده است.',
    'bad_identifiers'       => 'یک یا چند شناسه Twitch (شناسه‌ها، نام‌های کاربری) نامعتبر هستند.',
    'invalid_code'          => 'کد مجوز Twitch نامعتبر است یا منقضی شده است.',
    'invalid_refresh_token' => 'توکن نوسازی Twitch نامعتبر است: کاربر باید دوباره وارد شود.',
    'bad_request'           => 'Twitch درخواست را رد کرد.',
    'unauthorized'          => 'Twitch اطلاعات ورود را رد کرد.',
    'forbidden'             => 'این عملیات برای این حساب یا برنامه مجاز نیست.',
    'not_found'             => 'Twitch برای این درخواست چیزی پیدا نکرد.',
    'conflict'              => 'درخواست با وضعیت فعلی در Twitch تداخل دارد.',
    'gone'                  => 'این قابلیت Twitch دیگر در دسترس نیست.',
    'unprocessable'         => 'Twitch نتوانست درخواست را پردازش کند.',
    'rate_limited'          => 'Twitch درخواست‌های بسیار زیادی دریافت کرد. بعداً دوباره تلاش کنید.',
    'server_error'          => 'Twitch مشکلی دارد. بعداً دوباره تلاش کنید.',
    'network'               => 'دسترسی به Twitch ممکن نبود.',
    'error'                 => 'Twitch با یک خطا پاسخ داد.',
];
