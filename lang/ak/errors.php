<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch access token no nsɛ anaa ɛno bere atwam.',
    'missing_scope'         => 'Twitch access token no hia ho kwan (scope): :scope.',
    'app_token_required'    => 'Twitch endpoint yi gye app access token nko ara.',
    'user_mismatch'         => 'Ɔdefoɔ no nyɛ access token no wura.',
    'client_mismatch'       => 'Twitch client ID no nyɛ deɛ ɛyɛɛ nsɛmmɔne anaa token no.',
    'no_organization'       => 'Twitch app no nni ho abɔdeɛ ho nkitahodi.',
    'multiple_filters'      => 'Twitch gye filter baako pɛ bere biara.',
    'malformed_parameter'   => 'Parameter ":parameter" no nteɛ.',
    'bad_identifiers'       => 'Twitch identifiers (ID, login) baako anaa nea ɛboro saa nsɛ.',
    'invalid_code'          => 'Twitch authorization code no nsɛ anaa ɛno bere atwam.',
    'invalid_refresh_token' => 'Twitch refresh token no nsɛ: ɛsɛ sɛ odefoɔ no san hyɛ mu.',
    'bad_request'           => 'Twitch penee ahyɛdeɛ no.',
    'unauthorized'          => 'Twitch penee wo nsɛm no.',
    'forbidden'             => 'Wɔmma kwan amma saa adwuma yi wɔ saa akontaa anaa app yi ho.',
    'not_found'             => 'Twitch annya hwee amma ahyɛdeɛ yi.',
    'conflict'              => 'Ahyɛdeɛ no ne Twitch tebea a ɛwɔ hɔ seesei no hyia.',
    'gone'                  => 'Twitch adwuma yi nni hɔ bio.',
    'unprocessable'         => 'Twitch antumi anyɛ ahyɛdeɛ no.',
    'rate_limited'          => 'Twitch nya ahyɛdeɛ pii dodo. San yɛ akyire.',
    'server_error'          => 'Twitch wɔ ɔhaw. San yɛ akyire.',
    'network'               => 'Wɔantumi anni Twitch ho nkitahodi.',
    'error'                 => 'Twitch de mfomsoɔ buaa.',
];
