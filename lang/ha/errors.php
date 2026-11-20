<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Alamar shiga ta Twitch ba ta da inganci ko ta ƙare.',
    'missing_scope'         => 'Alamar shiga ta Twitch ba ta da izini (scope): :scope.',
    'app_token_required'    => 'Wannan ƙarshen Twitch yana karɓar alamar shiga ta app kawai.',
    'user_mismatch'         => 'Mai amfani ba shi ne mai alamar shiga ba.',
    'client_mismatch'       => 'ID ɗin abokin ciniki na Twitch ba shi ne wanda ya ƙirƙiri albarkatun ko alamar ba.',
    'no_organization'       => 'Ba a haɗa aikace-aikacen Twitch da ƙungiya ba.',
    'multiple_filters'      => 'Twitch yana karɓar matattara ɗaya kawai a lokaci guda.',
    'malformed_parameter'   => 'Sigar ":parameter" ba ta da kyau.',
    'bad_identifiers'       => 'Ɗaya ko fiye da masu ganewa na Twitch (ID, sunayen shiga) ba su da inganci.',
    'invalid_code'          => 'Lambar izini ta Twitch ba ta da inganci ko ta ƙare.',
    'invalid_refresh_token' => 'Alamar sabuntawa ta Twitch ba ta da inganci: dole mai amfani ya sake shiga.',
    'bad_request'           => 'Twitch ya ƙi buƙatar.',
    'unauthorized'          => 'Twitch ya ƙi bayanan shaida.',
    'forbidden'             => 'Ba a yarda da wannan aikin ga wannan asusun ko aikace-aikacen ba.',
    'not_found'             => 'Twitch bai sami komai ba don wannan buƙata.',
    'conflict'              => 'Buƙatar tana cin karo da halin da ake ciki a Twitch.',
    'gone'                  => 'Wannan fasalin Twitch ba ya nan kuma.',
    'unprocessable'         => 'Twitch bai iya sarrafa buƙatar ba.',
    'rate_limited'          => 'Twitch ya karɓi buƙatu da yawa. Sake gwadawa daga baya.',
    'server_error'          => 'Twitch yana da matsala. Sake gwadawa daga baya.',
    'network'               => 'Ba a iya tuntuɓar Twitch ba.',
    'error'                 => 'Twitch ya amsa da kuskure.',
];
