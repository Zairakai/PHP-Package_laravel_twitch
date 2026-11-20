<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch-ի մուտքի թոքենն անվավեր է կամ սպառվել է։',
    'missing_scope'         => 'Twitch-ի մուտքի թոքենին բացակայում է թույլտվություն (scope)՝ :scope։',
    'app_token_required'    => 'Այս Twitch վերջնակետը ընդունում է միայն հավելվածի մուտքի թոքեն։',
    'user_mismatch'         => 'Օգտատերը մուտքի թոքենի սեփականատերը չէ։',
    'client_mismatch'       => 'Twitch հաճախորդի ID-ն այն չէ, որը ստեղծել է ռեսուրսը կամ թոքենը։',
    'no_organization'       => 'Twitch հավելվածը կապված չէ կազմակերպության հետ։',
    'multiple_filters'      => 'Twitch-ն ընդունում է միայն մեկ ֆիլտր միաժամանակ։',
    'malformed_parameter'   => '«:parameter» պարամետրը սխալ է կազմված։',
    'bad_identifiers'       => 'Twitch-ի մեկ կամ մի քանի նույնացուցիչներ (ID, մուտքանուններ) անվավեր են։',
    'invalid_code'          => 'Twitch-ի թույլտվության կոդն անվավեր է կամ սպառվել է։',
    'invalid_refresh_token' => 'Twitch-ի թարմացման թոքենն անվավեր է. օգտատերը պետք է նորից մուտք գործի։',
    'bad_request'           => 'Twitch-ը մերժեց հարցումը։',
    'unauthorized'          => 'Twitch-ը մերժեց հավատարմագրերը։',
    'forbidden'             => 'Այս գործողությունը թույլատրված չէ այս հաշվի կամ հավելվածի համար։',
    'not_found'             => 'Twitch-ը այս հարցման համար ոչինչ չգտավ։',
    'conflict'              => 'Հարցումը հակասում է Twitch-ի ընթացիկ վիճակին։',
    'gone'                  => 'Twitch-ի այս գործառույթն այլևս հասանելի չէ։',
    'unprocessable'         => 'Twitch-ը չկարողացավ մշակել հարցումը։',
    'rate_limited'          => 'Twitch-ը չափազանց շատ հարցումներ ստացավ։ Փորձեք ավելի ուշ։',
    'server_error'          => 'Twitch-ում խնդիր կա։ Փորձեք ավելի ուշ։',
    'network'               => 'Twitch-ի հետ կապ հաստատել չհաջողվեց։',
    'error'                 => 'Twitch-ը պատասխանեց սխալով։',
];
