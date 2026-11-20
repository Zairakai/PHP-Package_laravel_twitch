<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch رسائي ٽوڪن غلط آهي يا ان جي مدت ختم ٿي وئي آهي.',
    'missing_scope'         => 'Twitch رسائي ٽوڪن ۾ اجازت (scope) ناهي: :scope.',
    'app_token_required'    => 'هي Twitch آخري نقطو صرف ايپ رسائي ٽوڪن قبول ڪري ٿو.',
    'user_mismatch'         => 'استعمال ڪندڙ رسائي ٽوڪن جو مالڪ ناهي.',
    'client_mismatch'       => 'Twitch ڪلائنٽ ID اهو ناهي جنهن وسيلو يا ٽوڪن ٺاهيو.',
    'no_organization'       => 'Twitch ايپليڪيشن ڪنهن تنظيم سان ڳنڍيل ناهي.',
    'multiple_filters'      => 'Twitch هڪ وقت ۾ صرف هڪ فلٽر قبول ڪري ٿو.',
    'malformed_parameter'   => 'پيراميٽر ":parameter" صحيح نموني ٺهيل ناهي.',
    'bad_identifiers'       => 'هڪ يا وڌيڪ Twitch سڃاڻپ ڪندڙ (ID، لاگ ان) غلط آهن.',
    'invalid_code'          => 'Twitch اجازت ڪوڊ غلط آهي يا ان جي مدت ختم ٿي وئي آهي.',
    'invalid_refresh_token' => 'Twitch ريفريش ٽوڪن غلط آهي: استعمال ڪندڙ کي ٻيهر لاگ ان ٿيڻو پوندو.',
    'bad_request'           => 'Twitch درخواست رد ڪري ڇڏي.',
    'unauthorized'          => 'Twitch سندون رد ڪري ڇڏيون.',
    'forbidden'             => 'هي عمل هن اڪائونٽ يا ايپليڪيشن لاءِ اجازت ناهي.',
    'not_found'             => 'Twitch کي هن درخواست لاءِ ڪجهه نه مليو.',
    'conflict'              => 'درخواست Twitch جي موجوده حالت سان ٽڪرائجي ٿي.',
    'gone'                  => 'هيءَ Twitch خصوصيت هاڻي دستياب ناهي.',
    'unprocessable'         => 'Twitch درخواست تي عمل ڪري نه سگهيو.',
    'rate_limited'          => 'Twitch کي تمام گهڻيون درخواستون مليون. پوءِ ٻيهر ڪوشش ڪريو.',
    'server_error'          => 'Twitch ۾ مسئلو آهي. پوءِ ٻيهر ڪوشش ڪريو.',
    'network'               => 'Twitch سان رابطو نه ٿي سگهيو.',
    'error'                 => 'Twitch غلطي سان جواب ڏنو.',
];
