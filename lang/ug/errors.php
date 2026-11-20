<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch زىيارەت بەلگىسى ئىناۋەتسىز ياكى ۋاقتى توشقان.',
    'missing_scope'         => 'Twitch زىيارەت بەلگىسىدە ئىجازەت (scope) يوق: :scope.',
    'app_token_required'    => 'بۇ Twitch ئاخىرقى نۇقتىسى پەقەت ئەپ زىيارەت بەلگىسىنىلا قوبۇل قىلىدۇ.',
    'user_mismatch'         => 'ئىشلەتكۈچى زىيارەت بەلگىسىنىڭ ئىگىسى ئەمەس.',
    'client_mismatch'       => 'Twitch خېرىدار ID سى بايلىق ياكى بەلگە ياراتقان ID ئەمەس.',
    'no_organization'       => 'Twitch ئەپى بىر تەشكىلاتقا باغلانمىغان.',
    'multiple_filters'      => 'Twitch بىر ۋاقىتتا پەقەت بىر سۈزگۈچنىلا قوبۇل قىلىدۇ.',
    'malformed_parameter'   => '«:parameter» پارامېتىرى توغرا شەكىللەنمىگەن.',
    'bad_identifiers'       => 'بىر ياكى بىر قانچە Twitch پەرقلەندۈرگۈچىسى (ID، كىرىش نامى) ئىناۋەتسىز.',
    'invalid_code'          => 'Twitch ئىجازەت كودى ئىناۋەتسىز ياكى ۋاقتى توشقان.',
    'invalid_refresh_token' => 'Twitch يېڭىلاش بەلگىسى ئىناۋەتسىز: ئىشلەتكۈچى قايتا كىرىشى كېرەك.',
    'bad_request'           => 'Twitch ئىلتىماسنى رەت قىلدى.',
    'unauthorized'          => 'Twitch كىملىك ئۇچۇرلىرىنى رەت قىلدى.',
    'forbidden'             => 'بۇ مەشغۇلاتقا بۇ ھېسابات ياكى ئەپ ئۈچۈن يول قويۇلمايدۇ.',
    'not_found'             => 'Twitch بۇ ئىلتىماس ئۈچۈن ھېچنېمە تاپالمىدى.',
    'conflict'              => 'ئىلتىماس Twitch تىكى نۆۋەتتىكى ھالەت بىلەن توقۇنۇشىدۇ.',
    'gone'                  => 'Twitch نىڭ بۇ ئىقتىدارى ئەمدى ئىشلەتكىلى بولمايدۇ.',
    'unprocessable'         => 'Twitch ئىلتىماسنى بىر تەرەپ قىلالمىدى.',
    'rate_limited'          => 'Twitch بەك كۆپ ئىلتىماسقا ئېرىشتى. كېيىن قايتا سىناڭ.',
    'server_error'          => 'Twitch تا مەسىلە بار. كېيىن قايتا سىناڭ.',
    'network'               => 'Twitch بىلەن ئالاقىلىشىش مۇمكىن بولمىدى.',
    'error'                 => 'Twitch خاتالىق بىلەن جاۋاب بەردى.',
];
