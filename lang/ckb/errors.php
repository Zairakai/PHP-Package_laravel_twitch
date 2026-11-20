<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'تۆکنی گەیشتنی Twitch نادروستە یان بەسەرچووە.',
    'missing_scope'         => 'تۆکنی گەیشتنی Twitch مۆڵەتێکی (scope) کەمە: :scope.',
    'app_token_required'    => 'ئەم خاڵی کۆتاییەی Twitch تەنها تۆکنی بەرنامە وەردەگرێت.',
    'user_mismatch'         => 'بەکارهێنەر خاوەنی تۆکنی گەیشتن نییە.',
    'client_mismatch'       => 'ناسنامەی کڕیاری Twitch ئەوە نییە کە سەرچاوە یان تۆکنەکەی دروست کردووە.',
    'no_organization'       => 'بەرنامەی Twitch بە هیچ ڕێکخراوێکەوە نەبەستراوەتەوە.',
    'multiple_filters'      => 'Twitch لە یەک کاتدا تەنها یەک فلتەر وەردەگرێت.',
    'malformed_parameter'   => 'پارامەتەری ":parameter" بە دروستی نەنووسراوە.',
    'bad_identifiers'       => 'یەک یان زیاتر لە ناسێنەرەکانی Twitch (ID، ناوی چوونەژوور) نادروستن.',
    'invalid_code'          => 'کۆدی مۆڵەتی Twitch نادروستە یان بەسەرچووە.',
    'invalid_refresh_token' => 'تۆکنی نوێکردنەوەی Twitch نادروستە: بەکارهێنەر دەبێت دووبارە بچێتە ژوورەوە.',
    'bad_request'           => 'Twitch داواکارییەکەی ڕەتکردەوە.',
    'unauthorized'          => 'Twitch زانیارییەکانی چوونەژوورەوەی ڕەتکردەوە.',
    'forbidden'             => 'ئەم کارە بۆ ئەم هەژمارە یان بەرنامەیە ڕێگەپێدراو نییە.',
    'not_found'             => 'Twitch هیچی بۆ ئەم داواکارییە نەدۆزییەوە.',
    'conflict'              => 'داواکارییەکە لەگەڵ دۆخی ئێستای Twitch ناکۆکە.',
    'gone'                  => 'ئەم تایبەتمەندییەی Twitch چیتر بەردەست نییە.',
    'unprocessable'         => 'Twitch نەیتوانی داواکارییەکە پرۆسێس بکات.',
    'rate_limited'          => 'Twitch داواکاری زۆری وەرگرتووە. دواتر دووبارە هەوڵ بدەرەوە.',
    'server_error'          => 'Twitch کێشەی هەیە. دواتر دووبارە هەوڵ بدەرەوە.',
    'network'               => 'نەتوانرا بە Twitch بگەیت.',
    'error'                 => 'Twitch بە هەڵەیەک وەڵامی دایەوە.',
];
