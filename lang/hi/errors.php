<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch एक्सेस टोकन अमान्य है या उसकी अवधि समाप्त हो गई है।',
    'missing_scope'         => 'Twitch एक्सेस टोकन में अनुमति (scope) नहीं है: :scope।',
    'app_token_required'    => 'यह Twitch एंडपॉइंट केवल ऐप एक्सेस टोकन स्वीकार करता है।',
    'user_mismatch'         => 'उपयोगकर्ता एक्सेस टोकन का स्वामी नहीं है।',
    'client_mismatch'       => 'Twitch क्लाइंट ID वह नहीं है जिसने संसाधन या टोकन बनाया।',
    'no_organization'       => 'Twitch ऐप किसी संगठन से जुड़ा नहीं है।',
    'multiple_filters'      => 'Twitch एक समय में केवल एक फ़िल्टर स्वीकार करता है।',
    'malformed_parameter'   => 'पैरामीटर ":parameter" गलत तरीके से बना है।',
    'bad_identifiers'       => 'एक या अधिक Twitch पहचानकर्ता (ID, लॉगिन) अमान्य हैं।',
    'invalid_code'          => 'Twitch प्राधिकरण कोड अमान्य है या उसकी अवधि समाप्त हो गई है।',
    'invalid_refresh_token' => 'Twitch रिफ़्रेश टोकन अमान्य है: उपयोगकर्ता को फिर से लॉगिन करना होगा।',
    'bad_request'           => 'Twitch ने अनुरोध अस्वीकार कर दिया।',
    'unauthorized'          => 'Twitch ने क्रेडेंशियल अस्वीकार कर दिए।',
    'forbidden'             => 'इस खाते या ऐप के लिए यह कार्रवाई अनुमत नहीं है।',
    'not_found'             => 'Twitch को इस अनुरोध के लिए कुछ नहीं मिला।',
    'conflict'              => 'अनुरोध Twitch की वर्तमान स्थिति से टकराता है।',
    'gone'                  => 'यह Twitch सुविधा अब उपलब्ध नहीं है।',
    'unprocessable'         => 'Twitch अनुरोध को प्रोसेस नहीं कर सका।',
    'rate_limited'          => 'Twitch को बहुत अधिक अनुरोध मिले। बाद में फिर कोशिश करें।',
    'server_error'          => 'Twitch में समस्या है। बाद में फिर कोशिश करें।',
    'network'               => 'Twitch से संपर्क नहीं हो सका।',
    'error'                 => 'Twitch ने त्रुटि के साथ उत्तर दिया।',
];
