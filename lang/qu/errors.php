<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch yaykuna tokenqa mana allinmi icha tukusqañam.',
    'missing_scope'         => 'Twitch yaykuna tokenpaq permiso (scope) pisin: :scope.',
    'app_token_required'    => 'Kay Twitch tukuy punkuqa app yaykuna tokenllatam chaskin.',
    'user_mismatch'         => 'Ruraqqa manam yaykuna tokenpa kaqninchu.',
    'client_mismatch'       => 'Twitch client ID manam chay kaqchu mayqinchus yachayta icha tokenta paqarichirqa.',
    'no_organization'       => 'Twitch appqa manam huk huñunakuyman tinkisqachu.',
    'multiple_filters'      => 'Twitch huk kutillapi huk filtrollatam chaskin.',
    'malformed_parameter'   => '":parameter" parámetroqa mana allinta ruwasqa.',
    'bad_identifiers'       => 'Twitch riqsichiqkuna (ID, yaykuna sutikuna) huk icha aswan mana allinmi.',
    'invalid_code'          => 'Twitch ruranapaq kamachikuy codigoqa mana allinmi icha tukusqañam.',
    'invalid_refresh_token' => 'Twitch musuqchay tokenqa mana allinmi: ruraqqa yapamanta yaykunan.',
    'bad_request'           => 'Twitch mañakuyta mana chaskirqachu.',
    'unauthorized'          => 'Twitch riqsichikuykunata mana chaskirqachu.',
    'forbidden'             => 'Kay ruwayqa mana kamachisqachu kay cuentapaq icha appmanta.',
    'not_found'             => 'Twitchqa kay mañakuypaq mana imatapas tarirqachu.',
    'conflict'              => 'Mañakuyqa Twitchpi kunan kaqwan chinkachinakuyta munan.',
    'gone'                  => 'Kay Twitch ruwayqa manañam kanchu.',
    'unprocessable'         => 'Twitch manam mañakuyta ruwayta atirqachu.',
    'rate_limited'          => 'Twitch aswan achkha mañakuykunata chaskirqa. Qhipamanta yapamanta ruwariy.',
    'server_error'          => 'Twitchqa sasachakuyniyuqmi. Qhipamanta yapamanta ruwariy.',
    'network'               => 'Twitchman manam chayayta atirqachu.',
    'error'                 => 'Twitch pantaywan kutichirqa.',
];
