<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch piekļuves marķieris ir nederīgs vai tā derīguma termiņš ir beidzies.',
    'missing_scope'         => 'Twitch piekļuves marķierim trūkst atļaujas (scope): :scope.',
    'app_token_required'    => 'Šis Twitch galapunkts pieņem tikai lietotnes piekļuves marķieri.',
    'user_mismatch'         => 'Lietotājs nav piekļuves marķiera īpašnieks.',
    'client_mismatch'       => 'Twitch klienta ID nav tas, kas izveidoja resursu vai marķieri.',
    'no_organization'       => 'Twitch lietotne nav saistīta ar organizāciju.',
    'multiple_filters'      => 'Twitch vienlaikus pieņem tikai vienu filtru.',
    'malformed_parameter'   => 'Parametrs “:parameter” ir nepareizi veidots.',
    'bad_identifiers'       => 'Viens vai vairāki Twitch identifikatori (ID, lietotājvārdi) nav derīgi.',
    'invalid_code'          => 'Twitch autorizācijas kods ir nederīgs vai tā derīguma termiņš ir beidzies.',
    'invalid_refresh_token' => 'Twitch atsvaidzināšanas marķieris ir nederīgs: lietotājam jāpierakstās vēlreiz.',
    'bad_request'           => 'Twitch noraidīja pieprasījumu.',
    'unauthorized'          => 'Twitch noraidīja akreditācijas datus.',
    'forbidden'             => 'Šī darbība nav atļauta šim kontam vai šai lietotnei.',
    'not_found'             => 'Twitch šim pieprasījumam neko neatrada.',
    'conflict'              => 'Pieprasījums konfliktē ar pašreizējo stāvokli Twitch.',
    'gone'                  => 'Šī Twitch funkcija vairs nav pieejama.',
    'unprocessable'         => 'Twitch nevarēja apstrādāt pieprasījumu.',
    'rate_limited'          => 'Twitch saņēma pārāk daudz pieprasījumu. Mēģiniet vēlāk.',
    'server_error'          => 'Twitch ir problēma. Mēģiniet vēlāk.',
    'network'               => 'Neizdevās sazināties ar Twitch.',
    'error'                 => 'Twitch atbildēja ar kļūdu.',
];
