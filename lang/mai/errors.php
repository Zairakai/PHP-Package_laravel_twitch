<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch एक्सेस टोकन अमान्य अछि वा ओकर अवधि समाप्त भ\' गेल अछि।',
    'missing_scope'         => 'Twitch एक्सेस टोकन मे अनुमति (scope) नहि अछि: :scope।',
    'app_token_required'    => 'ई Twitch एंडपॉइंट मात्र ऐप एक्सेस टोकन स्वीकार करैत अछि।',
    'user_mismatch'         => 'उपयोगकर्ता एक्सेस टोकनक मालिक नहि छथि।',
    'client_mismatch'       => 'Twitch क्लाइंट ID ओ नहि अछि जे संसाधन वा टोकन बनौलक।',
    'no_organization'       => 'Twitch ऐप कोनो संगठन सँ जुड़ल नहि अछि।',
    'multiple_filters'      => 'Twitch एक बेर मे मात्र एकटा फिल्टर स्वीकार करैत अछि।',
    'malformed_parameter'   => 'पैरामीटर ":parameter" गलत तरीका सँ बनल अछि।',
    'bad_identifiers'       => 'एक वा बेसी Twitch पहिचानकर्ता (ID, लॉगिन) अमान्य अछि।',
    'invalid_code'          => 'Twitch प्राधिकरण कोड अमान्य अछि वा ओकर अवधि समाप्त भ\' गेल अछि।',
    'invalid_refresh_token' => 'Twitch रिफ्रेश टोकन अमान्य अछि: उपयोगकर्ता केँ फेर सँ लॉगिन करय पड़त।',
    'bad_request'           => 'Twitch अनुरोध अस्वीकार कए देलक।',
    'unauthorized'          => 'Twitch क्रेडेंशियल अस्वीकार कए देलक।',
    'forbidden'             => 'ई कार्रवाई एहि खाता वा ऐप लेल अनुमत नहि अछि।',
    'not_found'             => 'Twitch केँ एहि अनुरोध लेल किछु नहि भेटल।',
    'conflict'              => 'अनुरोध Twitch क वर्तमान स्थिति सँ टकराइत अछि।',
    'gone'                  => 'ई Twitch सुविधा आब उपलब्ध नहि अछि।',
    'unprocessable'         => 'Twitch अनुरोध केँ प्रोसेस नहि क\' सकल।',
    'rate_limited'          => 'Twitch केँ बहुत अनुरोध भेटल। बाद मे फेर प्रयास करू।',
    'server_error'          => 'Twitch मे समस्या अछि। बाद मे फेर प्रयास करू।',
    'network'               => 'Twitch सँ संपर्क नहि भ\' सकल।',
    'error'                 => 'Twitch त्रुटिक संग उत्तर देलक।',
];
