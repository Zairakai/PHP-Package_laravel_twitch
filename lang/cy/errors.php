<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Mae tocyn mynediad Twitch yn annilys neu wedi dod i ben.',
    'missing_scope'         => 'Mae tocyn mynediad Twitch yn colli caniatâd (scope): :scope.',
    'app_token_required'    => 'Mae\'r pwynt terfyn Twitch hwn ond yn derbyn tocyn mynediad ap.',
    'user_mismatch'         => 'Nid y defnyddiwr yw perchennog y tocyn mynediad.',
    'client_mismatch'       => 'Nid ID cleient Twitch yw\'r un a greodd yr adnodd neu\'r tocyn.',
    'no_organization'       => 'Nid yw\'r cymhwysiad Twitch wedi\'i gysylltu â sefydliad.',
    'multiple_filters'      => 'Dim ond un hidlydd ar y tro y mae Twitch yn ei dderbyn.',
    'malformed_parameter'   => 'Mae\'r paramedr ":parameter" wedi\'i ffurfio\'n anghywir.',
    'bad_identifiers'       => 'Mae un neu fwy o ddynodwyr Twitch (IDau, mewngofnodion) yn annilys.',
    'invalid_code'          => 'Mae cod awdurdodi Twitch yn annilys neu wedi dod i ben.',
    'invalid_refresh_token' => 'Mae tocyn adnewyddu Twitch yn annilys: rhaid i\'r defnyddiwr fewngofnodi eto.',
    'bad_request'           => 'Gwrthododd Twitch y cais.',
    'unauthorized'          => 'Gwrthododd Twitch y manylion mewngofnodi.',
    'forbidden'             => 'Ni chaniateir y weithred hon ar gyfer y cyfrif neu\'r cymhwysiad hwn.',
    'not_found'             => 'Ni ddaeth Twitch o hyd i ddim ar gyfer y cais hwn.',
    'conflict'              => 'Mae\'r cais yn gwrthdaro â\'r cyflwr presennol ar Twitch.',
    'gone'                  => 'Nid yw\'r nodwedd Twitch hon ar gael mwyach.',
    'unprocessable'         => 'Ni allai Twitch brosesu\'r cais.',
    'rate_limited'          => 'Cafodd Twitch ormod o geisiadau. Rhowch gynnig arall arni yn nes ymlaen.',
    'server_error'          => 'Mae gan Twitch broblem. Rhowch gynnig arall arni yn nes ymlaen.',
    'network'               => 'Ni ellid cysylltu â Twitch.',
    'error'                 => 'Atebodd Twitch gyda gwall.',
];
