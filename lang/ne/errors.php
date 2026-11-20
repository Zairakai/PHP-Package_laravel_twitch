<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch पहुँच टोकन अमान्य छ वा यसको म्याद सकिएको छ।',
    'missing_scope'         => 'Twitch पहुँच टोकनमा अनुमति (scope) छैन: :scope।',
    'app_token_required'    => 'यो Twitch एन्डपोइन्टले एप पहुँच टोकन मात्र स्वीकार गर्दछ।',
    'user_mismatch'         => 'प्रयोगकर्ता पहुँच टोकनको मालिक होइन।',
    'client_mismatch'       => 'Twitch क्लाइन्ट ID ले स्रोत वा टोकन बनाएको होइन।',
    'no_organization'       => 'Twitch एप कुनै संस्थासँग जोडिएको छैन।',
    'multiple_filters'      => 'Twitch ले एक पटकमा एउटा फिल्टर मात्र स्वीकार गर्दछ।',
    'malformed_parameter'   => 'प्यारामिटर ":parameter" गलत तरिकाले बनेको छ।',
    'bad_identifiers'       => 'एक वा बढी Twitch पहिचानकर्ता (ID, लगइन) अमान्य छन्।',
    'invalid_code'          => 'Twitch प्राधिकरण कोड अमान्य छ वा यसको म्याद सकिएको छ।',
    'invalid_refresh_token' => 'Twitch रिफ्रेस टोकन अमान्य छ: प्रयोगकर्ताले फेरि लगइन गर्नुपर्छ।',
    'bad_request'           => 'Twitch ले अनुरोध अस्वीकार गर्‍यो।',
    'unauthorized'          => 'Twitch ले प्रमाणहरू अस्वीकार गर्‍यो।',
    'forbidden'             => 'यो खाता वा एपका लागि यो कार्य अनुमति छैन।',
    'not_found'             => 'Twitch ले यो अनुरोधका लागि केही फेला पारेन।',
    'conflict'              => 'अनुरोध Twitch को हालको अवस्थासँग बाझिन्छ।',
    'gone'                  => 'यो Twitch सुविधा अब उपलब्ध छैन।',
    'unprocessable'         => 'Twitch ले अनुरोध प्रशोधन गर्न सकेन।',
    'rate_limited'          => 'Twitch ले धेरै अनुरोधहरू प्राप्त गर्‍यो। पछि फेरि प्रयास गर्नुहोस्।',
    'server_error'          => 'Twitch मा समस्या छ। पछि फेरि प्रयास गर्नुहोस्।',
    'network'               => 'Twitch सम्पर्क गर्न सकिएन।',
    'error'                 => 'Twitch ले त्रुटिसहित जवाफ दियो।',
];
