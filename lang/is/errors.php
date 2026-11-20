<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Aðgangsteikn Twitch er ógilt eða útrunnið.',
    'missing_scope'         => 'Aðgangsteikn Twitch vantar leyfi (scope): :scope.',
    'app_token_required'    => 'Þessi endapunktur Twitch tekur aðeins við aðgangsteikni forrits.',
    'user_mismatch'         => 'Notandinn er ekki eigandi aðgangsteiknsins.',
    'client_mismatch'       => 'Auðkenni viðskiptavinar Twitch er ekki það sem bjó til auðlindina eða teiknið.',
    'no_organization'       => 'Twitch-forritið er ekki tengt stofnun.',
    'multiple_filters'      => 'Twitch tekur aðeins við einni síu í einu.',
    'malformed_parameter'   => 'Færibreytan „:parameter“ er rangt mynduð.',
    'bad_identifiers'       => 'Eitt eða fleiri auðkenni Twitch (auðkenni, innskráningarnöfn) eru ógild.',
    'invalid_code'          => 'Heimildarkóði Twitch er ógildur eða útrunninn.',
    'invalid_refresh_token' => 'Endurnýjunarteikn Twitch er ógilt: notandinn verður að skrá sig inn aftur.',
    'bad_request'           => 'Twitch hafnaði beiðninni.',
    'unauthorized'          => 'Twitch hafnaði auðkenningargögnunum.',
    'forbidden'             => 'Þessi aðgerð er ekki leyfð fyrir þennan reikning eða þetta forrit.',
    'not_found'             => 'Twitch fann ekkert fyrir þessa beiðni.',
    'conflict'              => 'Beiðnin stangast á við núverandi stöðu á Twitch.',
    'gone'                  => 'Þessi eiginleiki Twitch er ekki lengur í boði.',
    'unprocessable'         => 'Twitch gat ekki unnið úr beiðninni.',
    'rate_limited'          => 'Twitch fékk of margar beiðnir. Reyndu aftur síðar.',
    'server_error'          => 'Twitch á í vandræðum. Reyndu aftur síðar.',
    'network'               => 'Ekki náðist samband við Twitch.',
    'error'                 => 'Twitch svaraði með villu.',
];
