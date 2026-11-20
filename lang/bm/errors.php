<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch yɔrɔ sera tɔkɛn tɛ ɲɛ wala a waati tɛmɛna.',
    'missing_scope'         => 'Twitch yɔrɔ sera tɔkɛn ye sirabaw (scope) ɲini: :scope.',
    'app_token_required'    => 'Twitch endpoint in bɛ app yɔrɔ sera tɔkɛn doron minɛ.',
    'user_mismatch'         => 'Baarakɛla tɛ yɔrɔ sera tɔkɛn tigi ye.',
    'client_mismatch'       => 'Twitch client ID tɛ min ye resource wala tɔkɛn da.',
    'no_organization'       => 'Twitch app tɛ kelen-kelen ɲɔgɔn na ni jɛkulu ye.',
    'multiple_filters'      => 'Twitch bɛ filtere kelen doron minɛ waati kelen na.',
    'malformed_parameter'   => 'Parametere ":parameter" tɛ ɲɛ.',
    'bad_identifiers'       => 'Twitch dɔnniya (ID, login) kelen wala caman tɛ ɲɛ.',
    'invalid_code'          => 'Twitch sɛgɛsɛgɛli kɔdi tɛ ɲɛ wala a waati tɛmɛna.',
    'invalid_refresh_token' => 'Twitch kuraya tɔkɛn tɛ ɲɛ: baarakɛla ka kan ka don kokura.',
    'bad_request'           => 'Twitch ye ɲinini mun.',
    'unauthorized'          => 'Twitch ye dɔnniya mun.',
    'forbidden'             => 'Nin kɛwale tɛ sɛmɛ nin jatebɔ wala nin app ye.',
    'not_found'             => 'Twitch ma foyi sɔrɔ nin ɲinini kama.',
    'conflict'              => 'Ɲinini bɛ Twitch tɔɔrɔ sisan nɔ ɲɔgɔn na.',
    'gone'                  => 'Twitch fɛɛrɛ in tɛ yen tun.',
    'unprocessable'         => 'Twitch ma se ka ɲinini in kɛ.',
    'rate_limited'          => 'Twitch ye ɲinini caman sɔrɔ. Aw ka a lajɛ tuma dɔ fɔ.',
    'server_error'          => 'Twitch bɛ tɔɔrɔ la. Aw ka a lajɛ tuma dɔ fɔ.',
    'network'               => 'Twitch ma se ka sɔrɔ.',
    'error'                 => 'Twitch ye jaabi di ni fili ye.',
];
