<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch యాక్సెస్ టోకెన్ చెల్లదు లేదా గడువు ముగిసింది.',
    'missing_scope'         => 'Twitch యాక్సెస్ టోకెన్‌కు అనుమతి (scope) లేదు: :scope.',
    'app_token_required'    => 'ఈ Twitch ఎండ్‌పాయింట్ కేవలం యాప్ యాక్సెస్ టోకెన్‌ను మాత్రమే అంగీకరిస్తుంది.',
    'user_mismatch'         => 'వినియోగదారు యాక్సెస్ టోకెన్ యజమాని కాదు.',
    'client_mismatch'       => 'Twitch క్లయింట్ ID వనరును లేదా టోకెన్‌ను సృష్టించినది కాదు.',
    'no_organization'       => 'Twitch అప్లికేషన్ ఏ సంస్థకూ లింక్ కాలేదు.',
    'multiple_filters'      => 'Twitch ఒకేసారి ఒక ఫిల్టర్‌ను మాత్రమే అంగీకరిస్తుంది.',
    'malformed_parameter'   => 'పరామితి ":parameter" సరిగ్గా రూపొందలేదు.',
    'bad_identifiers'       => 'ఒకటి లేదా అంతకంటే ఎక్కువ Twitch గుర్తింపులు (ID, లాగిన్) చెల్లవు.',
    'invalid_code'          => 'Twitch అధికార కోడ్ చెల్లదు లేదా గడువు ముగిసింది.',
    'invalid_refresh_token' => 'Twitch రిఫ్రెష్ టోకెన్ చెల్లదు: వినియోగదారు మళ్లీ లాగిన్ చేయాలి.',
    'bad_request'           => 'Twitch అభ్యర్థనను తిరస్కరించింది.',
    'unauthorized'          => 'Twitch ఆధారాలను తిరస్కరించింది.',
    'forbidden'             => 'ఈ ఖాతాకు లేదా అప్లికేషన్‌కు ఈ చర్య అనుమతించబడదు.',
    'not_found'             => 'ఈ అభ్యర్థనకు Twitch కు ఏమీ దొరకలేదు.',
    'conflict'              => 'అభ్యర్థన Twitch లో ప్రస్తుత స్థితితో విరుద్ధంగా ఉంది.',
    'gone'                  => 'ఈ Twitch ఫీచర్ ఇకపై అందుబాటులో లేదు.',
    'unprocessable'         => 'Twitch అభ్యర్థనను ప్రాసెస్ చేయలేకపోయింది.',
    'rate_limited'          => 'Twitch కు చాలా ఎక్కువ అభ్యర్థనలు వచ్చాయి. తర్వాత మళ్లీ ప్రయత్నించండి.',
    'server_error'          => 'Twitch లో సమస్య ఉంది. తర్వాత మళ్లీ ప్రయత్నించండి.',
    'network'               => 'Twitch ను చేరుకోలేకపోయాము.',
    'error'                 => 'Twitch లోపంతో స్పందించింది.',
];
