<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch ॲक्सेस टोकन अवैध आहे किंवा त्याची मुदत संपली आहे.',
    'missing_scope'         => 'Twitch ॲक्सेस टोकनमध्ये परवानगी (scope) नाही: :scope.',
    'app_token_required'    => 'हा Twitch एंडपॉइंट फक्त ॲप ॲक्सेस टोकन स्वीकारतो.',
    'user_mismatch'         => 'वापरकर्ता ॲक्सेस टोकनचा मालक नाही.',
    'client_mismatch'       => 'Twitch क्लायंट ID हा संसाधन किंवा टोकन तयार करणारा नाही.',
    'no_organization'       => 'Twitch ॲप्लिकेशन कोणत्याही संस्थेशी जोडलेले नाही.',
    'multiple_filters'      => 'Twitch एका वेळी फक्त एक फिल्टर स्वीकारतो.',
    'malformed_parameter'   => 'पॅरामीटर ":parameter" चुकीच्या पद्धतीने तयार केला आहे.',
    'bad_identifiers'       => 'एक किंवा अधिक Twitch ओळखकर्ते (ID, लॉगिन) अवैध आहेत.',
    'invalid_code'          => 'Twitch अधिकृतता कोड अवैध आहे किंवा त्याची मुदत संपली आहे.',
    'invalid_refresh_token' => 'Twitch रिफ्रेश टोकन अवैध आहे: वापरकर्त्याने पुन्हा लॉगिन करणे आवश्यक आहे.',
    'bad_request'           => 'Twitch ने विनंती नाकारली.',
    'unauthorized'          => 'Twitch ने क्रेडेन्शियल्स नाकारली.',
    'forbidden'             => 'या खात्यासाठी किंवा ॲप्लिकेशनसाठी ही कृती परवानगीयोग्य नाही.',
    'not_found'             => 'Twitch ला या विनंतीसाठी काहीही आढळले नाही.',
    'conflict'              => 'विनंती Twitch वरील सध्याच्या स्थितीशी विसंगत आहे.',
    'gone'                  => 'हे Twitch वैशिष्ट्य आता उपलब्ध नाही.',
    'unprocessable'         => 'Twitch विनंतीवर प्रक्रिया करू शकले नाही.',
    'rate_limited'          => 'Twitch ला खूप जास्त विनंत्या मिळाल्या. नंतर पुन्हा प्रयत्न करा.',
    'server_error'          => 'Twitch मध्ये समस्या आहे. नंतर पुन्हा प्रयत्न करा.',
    'network'               => 'Twitch शी संपर्क साधता आला नाही.',
    'error'                 => 'Twitch ने त्रुटीसह उत्तर दिले.',
];
