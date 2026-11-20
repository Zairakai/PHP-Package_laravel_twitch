<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch ප්‍රවේශ ටෝකනය වලංගු නොවේ හෝ කල් ඉකුත් වී ඇත.',
    'missing_scope'         => 'Twitch ප්‍රවේශ ටෝකනයට අවසරය (scope) නොමැත: :scope.',
    'app_token_required'    => 'මෙම Twitch අවසාන ලක්ෂ්‍යය පිළිගන්නේ යෙදුම් ප්‍රවේශ ටෝකනය පමණි.',
    'user_mismatch'         => 'පරිශීලකයා ප්‍රවේශ ටෝකනයේ හිමිකරු නොවේ.',
    'client_mismatch'       => 'Twitch සේවාදායක ID එක සම්පත හෝ ටෝකනය නිර්මාණය කළ එක නොවේ.',
    'no_organization'       => 'Twitch යෙදුම සංවිධානයකට සම්බන්ධ කර නොමැත.',
    'multiple_filters'      => 'Twitch එකවර පිළිගන්නේ පෙරහන් එකක් පමණි.',
    'malformed_parameter'   => '":parameter" පරාමිතිය නිවැරදිව සකස් කර නොමැත.',
    'bad_identifiers'       => 'Twitch හඳුනාගැනීම් (ID, පිවිසුම්) එකක් හෝ වැඩි ගණනක් වලංගු නොවේ.',
    'invalid_code'          => 'Twitch අවසර කේතය වලංගු නොවේ හෝ කල් ඉකුත් වී ඇත.',
    'invalid_refresh_token' => 'Twitch නැවුම් කිරීමේ ටෝකනය වලංගු නොවේ: පරිශීලකයා නැවත පිවිසිය යුතුය.',
    'bad_request'           => 'Twitch ඉල්ලීම ප්‍රතික්ෂේප කළේය.',
    'unauthorized'          => 'Twitch අක්තපත්‍ර ප්‍රතික්ෂේප කළේය.',
    'forbidden'             => 'මෙම ගිණුම හෝ යෙදුම සඳහා මෙම ක්‍රියාව අවසර නැත.',
    'not_found'             => 'Twitch ට මෙම ඉල්ලීම සඳහා කිසිවක් හමු නොවීය.',
    'conflict'              => 'ඉල්ලීම Twitch හි වත්මන් තත්ත්වය සමඟ ගැටේ.',
    'gone'                  => 'මෙම Twitch විශේෂාංගය තවදුරටත් ලබා ගත නොහැක.',
    'unprocessable'         => 'Twitch ට ඉල්ලීම සැකසීමට නොහැකි විය.',
    'rate_limited'          => 'Twitch ට ඉල්ලීම් ඉතා වැඩි ගණනක් ලැබුණි. පසුව නැවත උත්සාහ කරන්න.',
    'server_error'          => 'Twitch හි ගැටළුවක් ඇත. පසුව නැවත උත්සාහ කරන්න.',
    'network'               => 'Twitch වෙත සම්බන්ධ විය නොහැකි විය.',
    'error'                 => 'Twitch දෝෂයකින් ප්‍රතිචාර දැක්වීය.',
];
