<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Tá comhartha rochtana Twitch neamhbhailí nó tá sé caite.',
    'missing_scope'         => 'Tá cead (scope) ar iarraidh ar chomhartha rochtana Twitch: :scope.',
    'app_token_required'    => 'Ní ghlacann an críochphointe Twitch seo ach le comhartha rochtana feidhmchláir.',
    'user_mismatch'         => 'Ní hé an t-úsáideoir úinéir an chomhartha rochtana.',
    'client_mismatch'       => 'Ní hé ID cliaint Twitch an ceann a chruthaigh an acmhainn nó an comhartha.',
    'no_organization'       => 'Níl feidhmchlár Twitch nasctha le heagraíocht.',
    'multiple_filters'      => 'Ní ghlacann Twitch ach le scagaire amháin ag an am.',
    'malformed_parameter'   => 'Tá an paraiméadar ":parameter" mífhoirmithe.',
    'bad_identifiers'       => 'Tá aitheantóir amháin nó níos mó de chuid Twitch (IDanna, logálacha isteach) neamhbhailí.',
    'invalid_code'          => 'Tá cód údaraithe Twitch neamhbhailí nó tá sé caite.',
    'invalid_refresh_token' => 'Tá comhartha athnuachana Twitch neamhbhailí: caithfidh an t-úsáideoir logáil isteach arís.',
    'bad_request'           => 'Dhiúltaigh Twitch don iarratas.',
    'unauthorized'          => 'Dhiúltaigh Twitch do na dintiúir.',
    'forbidden'             => 'Ní cheadaítear an gníomh seo don chuntas nó don fheidhmchlár seo.',
    'not_found'             => 'Níor aimsigh Twitch aon ní don iarratas seo.',
    'conflict'              => 'Tá an t-iarratas i gcoimhlint le staid reatha Twitch.',
    'gone'                  => 'Níl an ghné Twitch seo ar fáil a thuilleadh.',
    'unprocessable'         => 'Níorbh fhéidir le Twitch an t-iarratas a phróiseáil.',
    'rate_limited'          => 'Fuair Twitch an iomarca iarratas. Bain triail eile as níos déanaí.',
    'server_error'          => 'Tá fadhb ag Twitch. Bain triail eile as níos déanaí.',
    'network'               => 'Níorbh fhéidir teagmháil a dhéanamh le Twitch.',
    'error'                 => 'D\'fhreagair Twitch le hearráid.',
];
