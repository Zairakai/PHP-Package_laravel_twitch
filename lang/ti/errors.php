<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'ናይ Twitch መእተዊ ቶከን ቅቡል ኣይኮነን ወይ ግዜኡ ኣብቅዕ።',
    'missing_scope'         => 'ናይ Twitch መእተዊ ቶከን ፍቓድ (scope) የብሉን፦ :scope።',
    'app_token_required'    => 'እዚ ናይ Twitch መወዳእታ ነጥቢ ናይ መተግበሪ መእተዊ ቶከን ጥራይ ይቕበል።',
    'user_mismatch'         => 'እቲ ተጠቃሚ ናይ መእተዊ ቶከን ወናኒ ኣይኮነን።',
    'client_mismatch'       => 'እቲ ናይ Twitch ኣታዊ ID ነቲ ሃብቲ ወይ ቶከን ዝፈጠረ ኣይኮነን።',
    'no_organization'       => 'እቲ ናይ Twitch መተግበሪ ምስ ውዳበ ኣይተኣሳሰረን።',
    'multiple_filters'      => 'Twitch ኣብ ሓደ እዋን ሓደ ጥራይ መጻረዪ ይቕበል።',
    'malformed_parameter'   => 'እቲ ፓራሜተር ":parameter" ብትኽክል ኣይተሰርሐን።',
    'bad_identifiers'       => 'ሓደ ወይ ልዕሊኡ ናይ Twitch መለለዪታት (ID, መእተዊ) ቅቡል ኣይኮኑን።',
    'invalid_code'          => 'ናይ Twitch ናይ ፍቓድ ኮድ ቅቡል ኣይኮነን ወይ ግዜኡ ኣብቅዕ።',
    'invalid_refresh_token' => 'ናይ Twitch ናይ ምሕዳስ ቶከን ቅቡል ኣይኮነን፦ እቲ ተጠቃሚ ዳግማይ ክኣቱ ኣለዎ።',
    'bad_request'           => 'Twitch ነቲ ልመና ነጺጉ።',
    'unauthorized'          => 'Twitch ነቲ መረጋገጺታት ነጺጉ።',
    'forbidden'             => 'እዚ ተግባር ንዚ ሒሳብ ወይ መተግበሪ ኣይተፈቕደን።',
    'not_found'             => 'Twitch ንዚ ልመና ዝረኸቦ የለን።',
    'conflict'              => 'እቲ ልመና ምስ ሕጂ ዘሎ ኩነታት Twitch ይጋጮ።',
    'gone'                  => 'እዚ ናይ Twitch ባህሪ ሕጂ የለን።',
    'unprocessable'         => 'Twitch ነቲ ልመና ከስርሕ ኣይከኣለን።',
    'rate_limited'          => 'Twitch ኣዝዩ ብዙሕ ልመናታት ተቐቢሉ። ድሕሪ ግዜ ደጊምካ ፈትን።',
    'server_error'          => 'Twitch ጸገም ኣለዎ። ድሕሪ ግዜ ደጊምካ ፈትን።',
    'network'               => 'Twitch ክበጽሕ ኣይተኻእለን።',
    'error'                 => 'Twitch ብጌጋ መሊሱ።',
];
