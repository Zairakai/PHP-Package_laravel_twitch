<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch pristupni token nije valjan ili je istekao.',
    'missing_scope'         => 'Twitch pristupnom tokenu nedostaje dopuštenje (scope): :scope.',
    'app_token_required'    => 'Ova Twitch krajnja točka prihvaća samo token aplikacije.',
    'user_mismatch'         => 'Korisnik nije vlasnik pristupnog tokena.',
    'client_mismatch'       => 'Twitch ID klijenta nije onaj koji je stvorio resurs ili token.',
    'no_organization'       => 'Twitch aplikacija nije povezana s organizacijom.',
    'multiple_filters'      => 'Twitch prihvaća samo jedan filtar odjednom.',
    'malformed_parameter'   => 'Parametar ":parameter" nije ispravno oblikovan.',
    'bad_identifiers'       => 'Jedan ili više Twitch identifikatora (ID-ovi, korisnička imena) nisu valjani.',
    'invalid_code'          => 'Twitch autorizacijski kod nije valjan ili je istekao.',
    'invalid_refresh_token' => 'Twitch token za osvježavanje nije valjan: korisnik se mora ponovno prijaviti.',
    'bad_request'           => 'Twitch je odbio zahtjev.',
    'unauthorized'          => 'Twitch je odbio vjerodajnice.',
    'forbidden'             => 'Ova radnja nije dopuštena za ovaj račun ili aplikaciju.',
    'not_found'             => 'Twitch nije pronašao ništa za ovaj zahtjev.',
    'conflict'              => 'Zahtjev je u sukobu s trenutačnim stanjem na Twitchu.',
    'gone'                  => 'Ova Twitch funkcija više nije dostupna.',
    'unprocessable'         => 'Twitch nije mogao obraditi zahtjev.',
    'rate_limited'          => 'Twitch je primio previše zahtjeva. Pokušajte ponovno kasnije.',
    'server_error'          => 'Twitch ima problem. Pokušajte ponovno kasnije.',
    'network'               => 'Twitch nije dostupan.',
    'error'                 => 'Twitch je odgovorio pogreškom.',
];
