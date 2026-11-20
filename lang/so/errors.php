<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Calaamadda gelitaanka Twitch ma saxna ama waa dhacday.',
    'missing_scope'         => 'Calaamadda gelitaanka Twitch waxay u baahan tahay ogolaansho (scope): :scope.',
    'app_token_required'    => 'Meeshan dhammaadka ah ee Twitch waxay aqbashaa kaliya calaamadda gelitaanka app-ka.',
    'user_mismatch'         => 'Isticmaaluhu ma aha milkiilaha calaamadda gelitaanka.',
    'client_mismatch'       => 'ID-ga macmiilka Twitch ma aha kan abuuray khayraadka ama calaamadda.',
    'no_organization'       => 'Codsiga Twitch lama xirin urur.',
    'multiple_filters'      => 'Twitch waxay aqbashaa kaliya hal shaandhayn mar kasta.',
    'malformed_parameter'   => 'Halbeegga ":parameter" si sax ah looma dhisin.',
    'bad_identifiers'       => 'Aqoonsi ama in ka badan oo Twitch (ID, gelitaan) ma saxna.',
    'invalid_code'          => 'Koodhka ogolaanshaha Twitch ma saxna ama waa dhacay.',
    'invalid_refresh_token' => 'Calaamadda cusboonaysiinta Twitch ma saxna: isticmaaluhu waa inuu mar kale galaa.',
    'bad_request'           => 'Twitch waxay diiday codsiga.',
    'unauthorized'          => 'Twitch waxay diiday aqoonsiga.',
    'forbidden'             => 'Falkan looma oggola akoonkan ama codsigan.',
    'not_found'             => 'Twitch wax looma helin codsigan.',
    'conflict'              => 'Codsigu wuxuu khilaafsan yahay xaaladda hadda ee Twitch.',
    'gone'                  => 'Sifadan Twitch mar dambe lama heli karo.',
    'unprocessable'         => 'Twitch ma awoodin inay codsiga habayso.',
    'rate_limited'          => 'Twitch waxay heshay codsiyo aad u badan. Isku day mar dambe.',
    'server_error'          => 'Twitch waxay leedahay dhibaato. Isku day mar dambe.',
    'network'               => 'Twitch lama gaadhi karo.',
    'error'                 => 'Twitch waxay ku jawaabtay khalad.',
];
