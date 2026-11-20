<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch प्रवेशसङ्केतः अमान्यः अस्ति अथवा तस्य कालः समाप्तः।',
    'missing_scope'         => 'Twitch प्रवेशसङ्केते अनुज्ञा (scope) नास्ति: :scope।',
    'app_token_required'    => 'एषः Twitch अन्तबिन्दुः केवलं अनुप्रयोगप्रवेशसङ्केतं स्वीकरोति।',
    'user_mismatch'         => 'उपयोक्ता प्रवेशसङ्केतस्य स्वामी नास्ति।',
    'client_mismatch'       => 'Twitch ग्राहकपरिचयः सः नास्ति यः स्रोतः सङ्केतं वा निर्मितवान्।',
    'no_organization'       => 'Twitch अनुप्रयोगः संस्थया सह न योजितः।',
    'multiple_filters'      => 'Twitch एकस्मिन् समये केवलम् एकं छन्नकं स्वीकरोति।',
    'malformed_parameter'   => 'प्राचलः ":parameter" अशुद्धरूपेण निर्मितः।',
    'bad_identifiers'       => 'एकः अथवा अधिकाः Twitch परिचायकाः (ID, प्रवेशनामानि) अमान्याः सन्ति।',
    'invalid_code'          => 'Twitch अनुज्ञासङ्केतः अमान्यः अस्ति अथवा तस्य कालः समाप्तः।',
    'invalid_refresh_token' => 'Twitch नवीकरणसङ्केतः अमान्यः अस्ति: उपयोक्त्रा पुनः प्रवेशः करणीयः।',
    'bad_request'           => 'Twitch अनुरोधं प्रत्याख्यातवान्।',
    'unauthorized'          => 'Twitch प्रमाणपत्राणि प्रत्याख्यातवान्।',
    'forbidden'             => 'एतत् कर्म अस्य खातस्य अनुप्रयोगस्य वा कृते अनुमतं नास्ति।',
    'not_found'             => 'Twitch एतदर्थम् अनुरोधे किमपि न प्राप्तवान्।',
    'conflict'              => 'अनुरोधः Twitch इत्यस्य वर्तमानावस्थया सह विरुध्यते।',
    'gone'                  => 'एतत् Twitch वैशिष्ट्यं इदानीं न उपलभ्यते।',
    'unprocessable'         => 'Twitch अनुरोधं संसाधयितुं न शक्तवान्।',
    'rate_limited'          => 'Twitch बहूनि अनुरोधानि प्राप्तवान्। पश्चात् पुनः प्रयतस्व।',
    'server_error'          => 'Twitch इत्यत्र समस्या अस्ति। पश्चात् पुनः प्रयतस्व।',
    'network'               => 'Twitch सह सम्पर्कः न जातः।',
    'error'                 => 'Twitch दोषेण प्रत्युत्तरं दत्तवान्।',
];
