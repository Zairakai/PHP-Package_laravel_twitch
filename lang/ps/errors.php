<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'د Twitch د لاسرسي ټوکن ناسم دی یا موده یې پای ته رسیدلې ده.',
    'missing_scope'         => 'د Twitch د لاسرسي ټوکن اجازه (scope) نلري: :scope.',
    'app_token_required'    => 'دا Twitch پای ټکی یوازې د اپ د لاسرسي ټوکن مني.',
    'user_mismatch'         => 'کاروونکی د لاسرسي ټوکن مالک نه دی.',
    'client_mismatch'       => 'د Twitch د پیرودونکي ID هغه نه دی چې سرچینه یا ټوکن یې جوړ کړی.',
    'no_organization'       => 'د Twitch اپلیکیشن له یو سازمان سره نه دی تړل شوی.',
    'multiple_filters'      => 'Twitch په یو وخت کې یوازې یو فلټر مني.',
    'malformed_parameter'   => 'پیرامیټر «:parameter» سم نه دی جوړ شوی.',
    'bad_identifiers'       => 'د Twitch یو یا ډیر پېژندګلوي (ID، د ننوتلو نومونه) ناسم دي.',
    'invalid_code'          => 'د Twitch د واک کوډ ناسم دی یا موده یې پای ته رسیدلې ده.',
    'invalid_refresh_token' => 'د Twitch د تازه کولو ټوکن ناسم دی: کاروونکی باید بیا ننوځي.',
    'bad_request'           => 'Twitch غوښتنه رد کړه.',
    'unauthorized'          => 'Twitch سندونه رد کړل.',
    'forbidden'             => 'دا عمل د دې حساب یا اپلیکیشن لپاره اجازه نه لري.',
    'not_found'             => 'Twitch د دې غوښتنې لپاره هېڅ نه موندل.',
    'conflict'              => 'غوښتنه د Twitch له اوسنۍ حالت سره ټکر کوي.',
    'gone'                  => 'د Twitch دا ځانګړتیا نور شتون نلري.',
    'unprocessable'         => 'Twitch ونه توانېد غوښتنه پروسس کړي.',
    'rate_limited'          => 'Twitch ډیرې غوښتنې ترلاسه کړې. وروسته بیا هڅه وکړئ.',
    'server_error'          => 'Twitch ستونزه لري. وروسته بیا هڅه وکړئ.',
    'network'               => 'له Twitch سره اړیکه ونه شوه.',
    'error'                 => 'Twitch په یوه تېروتنه ځواب ورکړ.',
];
