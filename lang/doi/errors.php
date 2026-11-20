<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch एक्सेस टोकन अमान्य ऐ जां उदी मियाद खत्म होई गेई ऐ।',
    'missing_scope'         => 'Twitch एक्सेस टोकन च इजाजत (scope) नेईं ऐ: :scope।',
    'app_token_required'    => 'ए Twitch एंडपॉइंट सिर्फ ऐप एक्सेस टोकन मंजूर करदा ऐ।',
    'user_mismatch'         => 'यूजर एक्सेस टोकन दा मालक नेईं ऐ।',
    'client_mismatch'       => 'Twitch क्लाइंट ID ओह नेईं ऐ जिन्नै रिसोर्स जां टोकन बनाया।',
    'no_organization'       => 'Twitch ऐप कुसै संगठन कन्नै जुड़ोए दा नेईं ऐ।',
    'multiple_filters'      => 'Twitch इक बारी च सिर्फ इक फिल्टर मंजूर करदा ऐ।',
    'malformed_parameter'   => 'पैरामीटर ":parameter" गलत ढंगै कन्नै बने दा ऐ।',
    'bad_identifiers'       => 'इक जां इक थमां जादा Twitch पन्छानकर्ता (ID, लॉगिन) अमान्य न।',
    'invalid_code'          => 'Twitch प्राधिकरण कोड अमान्य ऐ जां उदी मियाद खत्म होई गेई ऐ।',
    'invalid_refresh_token' => 'Twitch रिफ्रेश टोकन अमान्य ऐ: यूजर गी फिरी लॉगिन करना पौना ऐ।',
    'bad_request'           => 'Twitch ने अनुरोध नामंजूर करी दित्ता।',
    'unauthorized'          => 'Twitch ने क्रेडेंशियल नामंजूर करी दित्ते।',
    'forbidden'             => 'ए कार्रवाई इस खाते जां ऐप आस्तै मंजूर नेईं ऐ।',
    'not_found'             => 'Twitch गी इस अनुरोध आस्तै कुतै किश नेईं मिले।',
    'conflict'              => 'अनुरोध Twitch दी मौजूदा स्थिति कन्नै टकरांदा ऐ।',
    'gone'                  => 'ए Twitch सुविधा हून उपलब्ध नेईं ऐ।',
    'unprocessable'         => 'Twitch अनुरोध गी प्रोसेस नेईं करी सकेआ।',
    'rate_limited'          => 'Twitch गी बड़े अनुरोध मिले। बाद च फिरी कोशश करो।',
    'server_error'          => 'Twitch च समस्या ऐ। बाद च फिरी कोशश करो।',
    'network'               => 'Twitch कन्नै संपर्क नेईं होई सकेआ।',
    'error'                 => 'Twitch ने गलती कन्नै जवाब दित्ता।',
];
