<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch pristupni token je nevažeći ili je istekao.',
    'missing_scope'         => 'Twitch pristupnom tokenu nedostaje dozvola (scope): :scope.',
    'app_token_required'    => 'Ova Twitch krajnja tačka prihvata samo token aplikacije.',
    'user_mismatch'         => 'Korisnik nije vlasnik pristupnog tokena.',
    'client_mismatch'       => 'Twitch ID klijenta nije onaj koji je kreirao resurs ili token.',
    'no_organization'       => 'Twitch aplikacija nije povezana s organizacijom.',
    'multiple_filters'      => 'Twitch prihvata samo jedan filter istovremeno.',
    'malformed_parameter'   => 'Parametar ":parameter" nije ispravno formiran.',
    'bad_identifiers'       => 'Jedan ili više Twitch identifikatora (ID-ovi, korisnička imena) nisu važeći.',
    'invalid_code'          => 'Twitch autorizacijski kod je nevažeći ili je istekao.',
    'invalid_refresh_token' => 'Twitch token za osvježavanje je nevažeći: korisnik se mora ponovo prijaviti.',
    'bad_request'           => 'Twitch je odbio zahtjev.',
    'unauthorized'          => 'Twitch je odbio vjerodajnice.',
    'forbidden'             => 'Ova radnja nije dozvoljena za ovaj račun ili aplikaciju.',
    'not_found'             => 'Twitch nije pronašao ništa za ovaj zahtjev.',
    'conflict'              => 'Zahtjev je u sukobu s trenutnim stanjem na Twitchu.',
    'gone'                  => 'Ova Twitch funkcija više nije dostupna.',
    'unprocessable'         => 'Twitch nije mogao obraditi zahtjev.',
    'rate_limited'          => 'Twitch je primio previše zahtjeva. Pokušajte ponovo kasnije.',
    'server_error'          => 'Twitch ima problem. Pokušajte ponovo kasnije.',
    'network'               => 'Twitch nije dostupan.',
    'error'                 => 'Twitch je odgovorio greškom.',
];
