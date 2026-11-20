<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'דער Twitch צוטריט־טאָקען איז אומגילטיק אָדער איז אָפּגעלאָפן.',
    'missing_scope'         => 'דעם Twitch צוטריט־טאָקען פעלט אַ דערלויבעניש (scope): :scope.',
    'app_token_required'    => 'די Twitch ענדפּאָינט נעמט נאָר אָן אַ אַפּ־צוטריט־טאָקען.',
    'user_mismatch'         => 'דער באַניצער איז ניט דער באַזיצער פון דעם צוטריט־טאָקען.',
    'client_mismatch'       => 'די Twitch קליענט־ID איז ניט די וואָס האָט באַשאַפֿן דעם רעסורס אָדער טאָקען.',
    'no_organization'       => 'די Twitch אַפּליקאַציע איז ניט פֿאַרבונדן מיט אַן אָרגאַניזאַציע.',
    'multiple_filters'      => 'Twitch נעמט אָן נאָר איין פֿילטער אין איין מאָל.',
    'malformed_parameter'   => 'דער פּאַראַמעטער ":parameter" איז ניט רעכט געבויט.',
    'bad_identifiers'       => 'איינער אָדער מער Twitch אידענטיפֿיצירער (ID, לאָגינס) זענען אומגילטיק.',
    'invalid_code'          => 'דער Twitch דערלויבעניש־קאָד איז אומגילטיק אָדער איז אָפּגעלאָפן.',
    'invalid_refresh_token' => 'דער Twitch דערפֿרישונג־טאָקען איז אומגילטיק: דער באַניצער דאַרף זיך ווידער אַרײַנלאָגירן.',
    'bad_request'           => 'Twitch האָט אָפּגעוואָרפֿן די בקשה.',
    'unauthorized'          => 'Twitch האָט אָפּגעוואָרפֿן די אַרײַנלאָג־דאַטן.',
    'forbidden'             => 'די אַקציע איז ניט דערלויבט פֿאַר דעם קאָנטאָ אָדער דער אַפּליקאַציע.',
    'not_found'             => 'Twitch האָט גאָרנישט געפֿונען פֿאַר דער בקשה.',
    'conflict'              => 'די בקשה שטייט אין קאָנפֿליקט מיט דעם איצטיקן שטאַט אויף Twitch.',
    'gone'                  => 'די Twitch שטריך איז מער ניט בנימצא.',
    'unprocessable'         => 'Twitch האָט ניט געקאָנט פֿאַרשפּאַרן די בקשה.',
    'rate_limited'          => 'Twitch האָט באַקומען צו פֿיל בקשות. פּרוּווט שפּעטער ווידער.',
    'server_error'          => 'Twitch האָט אַ פּראָבלעם. פּרוּווט שפּעטער ווידער.',
    'network'               => 'מען האָט ניט געקאָנט דערגרייכן Twitch.',
    'error'                 => 'Twitch האָט געענטפֿערט מיט אַ טעות.',
];
