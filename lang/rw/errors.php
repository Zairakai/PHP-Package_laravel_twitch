<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Ikimenyetso cyo kwinjira cya Twitch ntabwo gifite agaciro cyangwa cyararangiye.',
    'missing_scope'         => 'Ikimenyetso cyo kwinjira cya Twitch nta ruhushya (scope) gifite: :scope.',
    'app_token_required'    => 'Iki gikorwa cya Twitch cyemera gusa ikimenyetso cyo kwinjira cya porogaramu.',
    'user_mismatch'         => 'Umukoresha ntabwo ari nyiri ikimenyetso cyo kwinjira.',
    'client_mismatch'       => 'ID y\'umukiriya wa Twitch si yo yaremye umutungo cyangwa ikimenyetso.',
    'no_organization'       => 'Porogaramu ya Twitch ntiyahujwe n\'umuryango.',
    'multiple_filters'      => 'Twitch yemera akayunguruzo kamwe gusa icyarimwe.',
    'malformed_parameter'   => 'Parameter ":parameter" ntiyubatse neza.',
    'bad_identifiers'       => 'Indangamuntu imwe cyangwa nyinshi za Twitch (ID, amazina yo kwinjira) nta gaciro zifite.',
    'invalid_code'          => 'Kode y\'uruhushya rwa Twitch nta gaciro ifite cyangwa yararangiye.',
    'invalid_refresh_token' => 'Ikimenyetso cyo gusubiramo cya Twitch nta gaciro gifite: umukoresha agomba kongera kwinjira.',
    'bad_request'           => 'Twitch yanze icyifuzo.',
    'unauthorized'          => 'Twitch yanze amakuru y\'ibyangombwa.',
    'forbidden'             => 'Iki gikorwa nticyemewe kuri iyi konti cyangwa iyi porogaramu.',
    'not_found'             => 'Twitch nta cyo yabonye kuri iki cyifuzo.',
    'conflict'              => 'Icyifuzo kivuguruzanya n\'uko bimeze ubu kuri Twitch.',
    'gone'                  => 'Iyi ngingo ya Twitch ntikiboneka.',
    'unprocessable'         => 'Twitch ntiyashoboye gutunganya icyifuzo.',
    'rate_limited'          => 'Twitch yabonye ibyifuzo byinshi cyane. Ongera ugerageze nyuma.',
    'server_error'          => 'Twitch ifite ikibazo. Ongera ugerageze nyuma.',
    'network'               => 'Ntibishoboka kugera kuri Twitch.',
    'error'                 => 'Twitch yasubije ikosa.',
];
