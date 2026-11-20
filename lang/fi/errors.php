<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitchin käyttötunnus on virheellinen tai vanhentunut.',
    'missing_scope'         => 'Twitchin käyttötunnukselta puuttuu oikeus (scope): :scope.',
    'app_token_required'    => 'Tämä Twitchin päätepiste hyväksyy vain sovelluksen käyttötunnuksen.',
    'user_mismatch'         => 'Käyttäjä ei ole käyttötunnuksen omistaja.',
    'client_mismatch'       => 'Twitchin asiakastunnus ei ole se, joka loi resurssin tai tunnuksen.',
    'no_organization'       => 'Twitch-sovellusta ei ole liitetty organisaatioon.',
    'multiple_filters'      => 'Twitch hyväksyy vain yhden suodattimen kerrallaan.',
    'malformed_parameter'   => 'Parametri ":parameter" on virheellisesti muotoiltu.',
    'bad_identifiers'       => 'Yksi tai useampi Twitch-tunniste (ID, käyttäjätunnus) on virheellinen.',
    'invalid_code'          => 'Twitchin valtuutuskoodi on virheellinen tai vanhentunut.',
    'invalid_refresh_token' => 'Twitchin päivitystunnus on virheellinen: käyttäjän on kirjauduttava uudelleen.',
    'bad_request'           => 'Twitch hylkäsi pyynnön.',
    'unauthorized'          => 'Twitch hylkäsi tunnistetiedot.',
    'forbidden'             => 'Tämä toiminto ei ole sallittu tälle tilille tai sovellukselle.',
    'not_found'             => 'Twitch ei löytänyt mitään tälle pyynnölle.',
    'conflict'              => 'Pyyntö on ristiriidassa Twitchin nykyisen tilan kanssa.',
    'gone'                  => 'Tämä Twitchin ominaisuus ei ole enää käytettävissä.',
    'unprocessable'         => 'Twitch ei voinut käsitellä pyyntöä.',
    'rate_limited'          => 'Twitch sai liikaa pyyntöjä. Yritä myöhemmin uudelleen.',
    'server_error'          => 'Twitchillä on ongelma. Yritä myöhemmin uudelleen.',
    'network'               => 'Twitchiin ei saatu yhteyttä.',
    'error'                 => 'Twitch vastasi virheellä.',
];
