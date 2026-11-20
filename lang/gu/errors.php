<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch એક્સેસ ટોકન અમાન્ય છે અથવા સમાપ્ત થઈ ગયું છે.',
    'missing_scope'         => 'Twitch એક્સેસ ટોકનમાં પરવાનગી (scope) નથી: :scope.',
    'app_token_required'    => 'આ Twitch એન્ડપોઇન્ટ ફક્ત એપ એક્સેસ ટોકન સ્વીકારે છે.',
    'user_mismatch'         => 'વપરાશકર્તા એક્સેસ ટોકનનો માલિક નથી.',
    'client_mismatch'       => 'Twitch ક્લાયન્ટ ID એ નથી જેણે સંસાધન અથવા ટોકન બનાવ્યું.',
    'no_organization'       => 'Twitch એપ્લિકેશન કોઈ સંસ્થા સાથે જોડાયેલી નથી.',
    'multiple_filters'      => 'Twitch એક સમયે ફક્ત એક જ ફિલ્ટર સ્વીકારે છે.',
    'malformed_parameter'   => 'પેરામીટર ":parameter" ખોટી રીતે બનેલ છે.',
    'bad_identifiers'       => 'એક અથવા વધુ Twitch ઓળખકર્તાઓ (ID, લૉગિન) અમાન્ય છે.',
    'invalid_code'          => 'Twitch અધિકૃતતા કોડ અમાન્ય છે અથવા સમાપ્ત થઈ ગયો છે.',
    'invalid_refresh_token' => 'Twitch રિફ્રેશ ટોકન અમાન્ય છે: વપરાશકર્તાએ ફરીથી લૉગિન કરવું પડશે.',
    'bad_request'           => 'Twitch એ વિનંતીનો ઇનકાર કર્યો.',
    'unauthorized'          => 'Twitch એ ઓળખપત્રોનો ઇનકાર કર્યો.',
    'forbidden'             => 'આ ખાતા અથવા એપ્લિકેશન માટે આ ક્રિયા મંજૂર નથી.',
    'not_found'             => 'Twitch ને આ વિનંતી માટે કંઈ મળ્યું નથી.',
    'conflict'              => 'વિનંતી Twitch પરની વર્તમાન સ્થિતિ સાથે સંઘર્ષમાં છે.',
    'gone'                  => 'આ Twitch સુવિધા હવે ઉપલબ્ધ નથી.',
    'unprocessable'         => 'Twitch વિનંતી પર પ્રક્રિયા કરી શક્યું નથી.',
    'rate_limited'          => 'Twitch ને ઘણી બધી વિનંતીઓ મળી. પછી ફરી પ્રયાસ કરો.',
    'server_error'          => 'Twitch માં સમસ્યા છે. પછી ફરી પ્રયાસ કરો.',
    'network'               => 'Twitch સુધી પહોંચી શકાયું નથી.',
    'error'                 => 'Twitch એ ભૂલ સાથે જવાબ આપ્યો.',
];
