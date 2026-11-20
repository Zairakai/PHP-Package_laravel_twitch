<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Tokena gihîştinê ya Twitch nederbasdar e an jî dem ê wê qediyaye.',
    'missing_scope'         => 'Tokena gihîştinê ya Twitch destûrek (scope) kêm e: :scope.',
    'app_token_required'    => 'Ev xala dawî ya Twitch tenê tokena gihîştinê ya sepanê qebûl dike.',
    'user_mismatch'         => 'Bikarhêner xwediyê tokena gihîştinê nîne.',
    'client_mismatch'       => 'ID ya xerîdar a Twitch ne ew e ku çavkanî an token afirandiye.',
    'no_organization'       => 'Sepana Twitch bi rêxistinekê ve nehatiye girêdan.',
    'multiple_filters'      => 'Twitch di carekê de tenê yek parzûnê qebûl dike.',
    'malformed_parameter'   => 'Parametreya ":parameter" çewt hatiye avakirin.',
    'bad_identifiers'       => 'Yek an çend nasnameyên Twitch (ID, navên têketinê) nederbasdar in.',
    'invalid_code'          => 'Koda destûrdayînê ya Twitch nederbasdar e an jî dem ê wê qediyaye.',
    'invalid_refresh_token' => 'Tokena nûkirinê ya Twitch nederbasdar e: divê bikarhêner dîsa têkeve.',
    'bad_request'           => 'Twitch daxwaz red kir.',
    'unauthorized'          => 'Twitch agahiyên têketinê red kir.',
    'forbidden'             => 'Ev çalakî ji bo vê hesabê an sepanê nayê destûr kirin.',
    'not_found'             => 'Twitch ji bo vê daxwazê tiştek nedît.',
    'conflict'              => 'Daxwaz bi rewşa heyî ya li Twitch re ne li hev e.',
    'gone'                  => 'Ev taybetmendiya Twitch êdî nayê bikaranîn.',
    'unprocessable'         => 'Twitch nikaribû daxwazê pêvajo bike.',
    'rate_limited'          => 'Twitch gelek daxwaz wergirtin. Paşê dîsa biceribîne.',
    'server_error'          => 'Twitch pirsgirêkek heye. Paşê dîsa biceribîne.',
    'network'               => 'Twitch nehat gihîştin.',
    'error'                 => 'Twitch bi çewtiyekê bersiv da.',
];
