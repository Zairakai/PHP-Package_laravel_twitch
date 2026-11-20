<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Ithokheni yokufinyelela yeTwitch ayivumelekile noma iphelelwe yisikhathi.',
    'missing_scope'         => 'Ithokheni yokufinyelela yeTwitch ayinayo imvume (scope): :scope.',
    'app_token_required'    => 'Lesi siphetho seTwitch samukela kuphela ithokheni yokufinyelela yohlelo lokusebenza.',
    'user_mismatch'         => 'Umsebenzisi akayena umnikazi wethokheni yokufinyelela.',
    'client_mismatch'       => 'I-ID yeklayenti yeTwitch ayiyona leyo ekhiqize insiza noma ithokheni.',
    'no_organization'       => 'Uhlelo lokusebenza lweTwitch aluxhumene nenhlangano.',
    'multiple_filters'      => 'I-Twitch yamukela isihlungi esisodwa kuphela ngesikhathi.',
    'malformed_parameter'   => 'Ipharamitha ":parameter" ayakhiwe kahle.',
    'bad_identifiers'       => 'Isihlonzi esisodwa noma ngaphezulu seTwitch (ID, ukungena) asivumelekile.',
    'invalid_code'          => 'Ikhodi yokugunyaza yeTwitch ayivumelekile noma iphelelwe yisikhathi.',
    'invalid_refresh_token' => 'Ithokheni yokuvuselela yeTwitch ayivumelekile: umsebenzisi kufanele angene futhi.',
    'bad_request'           => 'I-Twitch yenqabile isicelo.',
    'unauthorized'          => 'I-Twitch yenqabile imininingwane yokungena.',
    'forbidden'             => 'Lesi senzo asivunyelwe kule akhawunti noma kuhlelo lokusebenza.',
    'not_found'             => 'I-Twitch ayitholanga lutho kuleli cala.',
    'conflict'              => 'Isicelo siphikisana nesimo samanje kuTwitch.',
    'gone'                  => 'Leli nhlobo leTwitch alisatholakali.',
    'unprocessable'         => 'I-Twitch ayikwazanga ukucubungula isicelo.',
    'rate_limited'          => 'I-Twitch yamukele izicelo eziningi kakhulu. Zama futhi ngemuva kwesikhathi.',
    'server_error'          => 'I-Twitch inenkinga. Zama futhi ngemuva kwesikhathi.',
    'network'               => 'Ayikwazanga ukufinyelela kuTwitch.',
    'error'                 => 'I-Twitch iphendule ngephutha.',
];
