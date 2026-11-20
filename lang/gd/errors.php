<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Chan eil tòcan inntrigidh Twitch dligheach no tha e air ruith a-mach.',
    'missing_scope'         => 'Tha cead (scope) a dhìth air tòcan inntrigidh Twitch: :scope.',
    'app_token_required'    => 'Cha ghabh am puing-chrìche Twitch seo ach ri tòcan inntrigidh aplacaid.',
    'user_mismatch'         => 'Chan e an cleachdaiche sealbhadair an tòcain inntrigidh.',
    'client_mismatch'       => 'Chan e ID cliant Twitch am fear a chruthaich an goireas no an tòcan.',
    'no_organization'       => 'Chan eil an aplacaid Twitch ceangailte ri buidheann.',
    'multiple_filters'      => 'Cha ghabh Twitch ach ri aon chriathrag aig an aon àm.',
    'malformed_parameter'   => 'Tha am paramadair ":parameter" air a dhèanamh ceàrr.',
    'bad_identifiers'       => 'Chan eil aon no barrachd de dh\'aithnichearan Twitch (IDan, logaidhean a-steach) dligheach.',
    'invalid_code'          => 'Chan eil còd ùghdarrachaidh Twitch dligheach no tha e air ruith a-mach.',
    'invalid_refresh_token' => 'Chan eil tòcan ath-nuadhachaidh Twitch dligheach: feumaidh an cleachdaiche logadh a-steach a-rithist.',
    'bad_request'           => 'Dhiùlt Twitch an t-iarrtas.',
    'unauthorized'          => 'Dhiùlt Twitch na teisteanasan.',
    'forbidden'             => 'Chan eil an gnìomh seo ceadaichte airson a\' chunntais no an aplacaid seo.',
    'not_found'             => 'Cha d\' fhuair Twitch dad airson an iarrtais seo.',
    'conflict'              => 'Tha an t-iarrtas a\' strì ri staid làithreach Twitch.',
    'gone'                  => 'Chan eil am feart Twitch seo ri fhaighinn tuilleadh.',
    'unprocessable'         => 'Cha b\' urrainn do Twitch an t-iarrtas a phròiseasadh.',
    'rate_limited'          => 'Fhuair Twitch cus iarrtasan. Feuch a-rithist nas fhaide air adhart.',
    'server_error'          => 'Tha duilgheadas aig Twitch. Feuch a-rithist nas fhaide air adhart.',
    'network'               => 'Cha deach ceangal ri Twitch a dhèanamh.',
    'error'                 => 'Fhreagair Twitch le mearachd.',
];
