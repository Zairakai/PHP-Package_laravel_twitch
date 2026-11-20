<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'የTwitch መዳረሻ ማስመሰያ ልክ አይደለም ወይም ጊዜው አልፏል።',
    'missing_scope'         => 'የTwitch መዳረሻ ማስመሰያ ፈቃድ (scope) ይጎድለዋል፦ :scope።',
    'app_token_required'    => 'ይህ የTwitch የመጨረሻ ነጥብ የመተግበሪያ መዳረሻ ማስመሰያ ብቻ ይቀበላል።',
    'user_mismatch'         => 'ተጠቃሚው የመዳረሻ ማስመሰያው ባለቤት አይደለም።',
    'client_mismatch'       => 'የTwitch ደንበኛ መታወቂያ ሀብቱን ወይም ማስመሰያውን የፈጠረው አይደለም።',
    'no_organization'       => 'የTwitch መተግበሪያ ከድርጅት ጋር አልተገናኘም።',
    'multiple_filters'      => 'Twitch በአንድ ጊዜ አንድ ማጣሪያ ብቻ ይቀበላል።',
    'malformed_parameter'   => 'መለኪያው ":parameter" ትክክል አይደለም።',
    'bad_identifiers'       => 'አንድ ወይም ከዚያ በላይ የTwitch መለያዎች (መታወቂያዎች፣ መግቢያዎች) ልክ አይደሉም።',
    'invalid_code'          => 'የTwitch የፈቃድ ኮድ ልክ አይደለም ወይም ጊዜው አልፏል።',
    'invalid_refresh_token' => 'የTwitch ማደሻ ማስመሰያ ልክ አይደለም፦ ተጠቃሚው እንደገና መግባት አለበት።',
    'bad_request'           => 'Twitch ጥያቄውን አልተቀበለም።',
    'unauthorized'          => 'Twitch ምስክርነቶችን አልተቀበለም።',
    'forbidden'             => 'ይህ እርምጃ ለዚህ መለያ ወይም መተግበሪያ አይፈቀድም።',
    'not_found'             => 'Twitch ለዚህ ጥያቄ ምንም አላገኘም።',
    'conflict'              => 'ጥያቄው በTwitch ላይ ካለው ወቅታዊ ሁኔታ ጋር ይጋጫል።',
    'gone'                  => 'ይህ የTwitch ባህሪ ከአሁን በኋላ አይገኝም።',
    'unprocessable'         => 'Twitch ጥያቄውን ማስኬድ አልቻለም።',
    'rate_limited'          => 'Twitch ብዙ ጥያቄዎችን ተቀብሏል። ቆይተው እንደገና ይሞክሩ።',
    'server_error'          => 'Twitch ችግር አጋጥሞታል። ቆይተው እንደገና ይሞክሩ።',
    'network'               => 'Twitch ላይ መድረስ አልተቻለም።',
    'error'                 => 'Twitch በስህተት ምላሽ ሰጥቷል።',
];
