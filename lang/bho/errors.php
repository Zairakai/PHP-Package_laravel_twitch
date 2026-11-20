<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch एक्सेस टोकन अमान्य बा या खतम हो गइल बा।',
    'missing_scope'         => 'Twitch एक्सेस टोकन में अनुमति (scope) नइखे: :scope।',
    'app_token_required'    => 'ई Twitch एंडपॉइंट खाली ऐप एक्सेस टोकन मानेला।',
    'user_mismatch'         => 'यूजर एक्सेस टोकन के मालिक नइखे।',
    'client_mismatch'       => 'Twitch क्लाइंट ID उ नइखे जे रिसोर्स या टोकन बनइलस।',
    'no_organization'       => 'Twitch ऐप कौनो संगठन से जुड़ल नइखे।',
    'multiple_filters'      => 'Twitch एक बेर में खाली एक फिल्टर मानेला।',
    'malformed_parameter'   => 'पैरामीटर ":parameter" गलत तरीका से बनल बा।',
    'bad_identifiers'       => 'एक या ढेर Twitch पहचानकर्ता (ID, लॉगिन) अमान्य बा।',
    'invalid_code'          => 'Twitch प्राधिकरण कोड अमान्य बा या खतम हो गइल बा।',
    'invalid_refresh_token' => 'Twitch रिफ्रेश टोकन अमान्य बा: यूजर के फेर से लॉगिन करे के पड़ी।',
    'bad_request'           => 'Twitch अनुरोध मना कर दिहलस।',
    'unauthorized'          => 'Twitch क्रेडेंशियल मना कर दिहलस।',
    'forbidden'             => 'ई कार्रवाई एह खाता या ऐप खातिर अनुमत नइखे।',
    'not_found'             => 'Twitch के एह अनुरोध खातिर कुछ ना मिलल।',
    'conflict'              => 'अनुरोध Twitch के मौजूदा स्थिति से टकरात बा।',
    'gone'                  => 'ई Twitch सुविधा अब उपलब्ध नइखे।',
    'unprocessable'         => 'Twitch अनुरोध के प्रोसेस ना कर सकल।',
    'rate_limited'          => 'Twitch के बहुत अनुरोध मिलल। बाद में फेर कोशिश करीं।',
    'server_error'          => 'Twitch में समस्या बा। बाद में फेर कोशिश करीं।',
    'network'               => 'Twitch से संपर्क ना हो सकल।',
    'error'                 => 'Twitch गलती के साथ जवाब दिहलस।',
];
