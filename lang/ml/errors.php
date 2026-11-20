<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch ആക്സസ് ടോക്കൺ അസാധുവാണ് അല്ലെങ്കിൽ കാലഹരണപ്പെട്ടു.',
    'missing_scope'         => 'Twitch ആക്സസ് ടോക്കണിന് അനുമതി (scope) ഇല്ല: :scope.',
    'app_token_required'    => 'ഈ Twitch എൻഡ്‌പോയിന്റ് ആപ്പ് ആക്സസ് ടോക്കൺ മാത്രമേ സ്വീകരിക്കൂ.',
    'user_mismatch'         => 'ഉപയോക്താവ് ആക്സസ് ടോക്കണിന്റെ ഉടമയല്ല.',
    'client_mismatch'       => 'Twitch ക്ലയന്റ് ID വിഭവമോ ടോക്കണോ സൃഷ്ടിച്ചതല്ല.',
    'no_organization'       => 'Twitch ആപ്ലിക്കേഷൻ ഒരു സ്ഥാപനവുമായി ബന്ധിപ്പിച്ചിട്ടില്ല.',
    'multiple_filters'      => 'Twitch ഒരു സമയം ഒരു ഫിൽട്ടർ മാത്രമേ സ്വീകരിക്കൂ.',
    'malformed_parameter'   => 'പാരാമീറ്റർ ":parameter" ശരിയായി രൂപപ്പെടുത്തിയിട്ടില്ല.',
    'bad_identifiers'       => 'ഒന്നോ അതിലധികമോ Twitch ഐഡന്റിഫയറുകൾ (ID, ലോഗിൻ) അസാധുവാണ്.',
    'invalid_code'          => 'Twitch അംഗീകാര കോഡ് അസാധുവാണ് അല്ലെങ്കിൽ കാലഹരണപ്പെട്ടു.',
    'invalid_refresh_token' => 'Twitch റിഫ്രഷ് ടോക്കൺ അസാധുവാണ്: ഉപയോക്താവ് വീണ്ടും ലോഗിൻ ചെയ്യണം.',
    'bad_request'           => 'Twitch അഭ്യർത്ഥന നിരസിച്ചു.',
    'unauthorized'          => 'Twitch ക്രെഡൻഷ്യലുകൾ നിരസിച്ചു.',
    'forbidden'             => 'ഈ അക്കൗണ്ടിനോ ആപ്ലിക്കേഷനോ ഈ പ്രവർത്തനം അനുവദനീയമല്ല.',
    'not_found'             => 'ഈ അഭ്യർത്ഥനയ്ക്ക് Twitch ന് ഒന്നും കണ്ടെത്താനായില്ല.',
    'conflict'              => 'അഭ്യർത്ഥന Twitch ലെ നിലവിലെ അവസ്ഥയുമായി ഏറ്റുമുട്ടുന്നു.',
    'gone'                  => 'ഈ Twitch സവിശേഷത ഇനി ലഭ്യമല്ല.',
    'unprocessable'         => 'Twitch ന് അഭ്യർത്ഥന പ്രോസസ്സ് ചെയ്യാനായില്ല.',
    'rate_limited'          => 'Twitch ന് വളരെയധികം അഭ്യർത്ഥനകൾ ലഭിച്ചു. പിന്നീട് വീണ്ടും ശ്രമിക്കുക.',
    'server_error'          => 'Twitch ന് ഒരു പ്രശ്നമുണ്ട്. പിന്നീട് വീണ്ടും ശ്രമിക്കുക.',
    'network'               => 'Twitch ലേക്ക് എത്താനായില്ല.',
    'error'                 => 'Twitch ഒരു പിശകോടെ പ്രതികരിച്ചു.',
];
