<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch ಪ್ರವೇಶ ಟೋಕನ್ ಅಮಾನ್ಯವಾಗಿದೆ ಅಥವಾ ಅವಧಿ ಮುಗಿದಿದೆ.',
    'missing_scope'         => 'Twitch ಪ್ರವೇಶ ಟೋಕನ್‌ಗೆ ಅನುಮತಿ (scope) ಇಲ್ಲ: :scope.',
    'app_token_required'    => 'ಈ Twitch ಎಂಡ್‌ಪಾಯಿಂಟ್ ಕೇವಲ ಆ್ಯಪ್ ಪ್ರವೇಶ ಟೋಕನ್ ಅನ್ನು ಸ್ವೀಕರಿಸುತ್ತದೆ.',
    'user_mismatch'         => 'ಬಳಕೆದಾರರು ಪ್ರವೇಶ ಟೋಕನ್‌ನ ಮಾಲೀಕರಲ್ಲ.',
    'client_mismatch'       => 'Twitch ಕ್ಲೈಂಟ್ ID ಸಂಪನ್ಮೂಲ ಅಥವಾ ಟೋಕನ್ ರಚಿಸಿದ್ದಲ್ಲ.',
    'no_organization'       => 'Twitch ಅಪ್ಲಿಕೇಶನ್ ಯಾವುದೇ ಸಂಸ್ಥೆಗೆ ಸಂಪರ್ಕಗೊಂಡಿಲ್ಲ.',
    'multiple_filters'      => 'Twitch ಒಂದು ಸಮಯದಲ್ಲಿ ಕೇವಲ ಒಂದು ಫಿಲ್ಟರ್ ಅನ್ನು ಸ್ವೀಕರಿಸುತ್ತದೆ.',
    'malformed_parameter'   => 'ಪ್ಯಾರಾಮೀಟರ್ ":parameter" ಸರಿಯಾಗಿ ರಚಿತವಾಗಿಲ್ಲ.',
    'bad_identifiers'       => 'ಒಂದು ಅಥವಾ ಹೆಚ್ಚು Twitch ಗುರುತಿಸುವಿಕೆಗಳು (ID, ಲಾಗಿನ್) ಅಮಾನ್ಯವಾಗಿವೆ.',
    'invalid_code'          => 'Twitch ಅಧಿಕಾರ ಕೋಡ್ ಅಮಾನ್ಯವಾಗಿದೆ ಅಥವಾ ಅವಧಿ ಮುಗಿದಿದೆ.',
    'invalid_refresh_token' => 'Twitch ರಿಫ್ರೆಶ್ ಟೋಕನ್ ಅಮಾನ್ಯವಾಗಿದೆ: ಬಳಕೆದಾರರು ಮತ್ತೆ ಲಾಗಿನ್ ಆಗಬೇಕು.',
    'bad_request'           => 'Twitch ವಿನಂತಿಯನ್ನು ತಿರಸ್ಕರಿಸಿದೆ.',
    'unauthorized'          => 'Twitch ರುಜುವಾತುಗಳನ್ನು ತಿರಸ್ಕರಿಸಿದೆ.',
    'forbidden'             => 'ಈ ಖಾತೆ ಅಥವಾ ಅಪ್ಲಿಕೇಶನ್‌ಗೆ ಈ ಕ್ರಿಯೆಗೆ ಅನುಮತಿ ಇಲ್ಲ.',
    'not_found'             => 'ಈ ವಿನಂತಿಗೆ Twitch ಗೆ ಏನೂ ಸಿಗಲಿಲ್ಲ.',
    'conflict'              => 'ವಿನಂತಿಯು Twitch ನ ಪ್ರಸ್ತುತ ಸ್ಥಿತಿಯೊಂದಿಗೆ ಸಂಘರ್ಷಿಸುತ್ತದೆ.',
    'gone'                  => 'ಈ Twitch ವೈಶಿಷ್ಟ್ಯ ಇನ್ನು ಲಭ್ಯವಿಲ್ಲ.',
    'unprocessable'         => 'Twitch ವಿನಂತಿಯನ್ನು ಸಂಸ್ಕರಿಸಲು ಸಾಧ್ಯವಾಗಲಿಲ್ಲ.',
    'rate_limited'          => 'Twitch ಗೆ ಹಲವಾರು ವಿನಂತಿಗಳು ಬಂದಿವೆ. ನಂತರ ಮತ್ತೆ ಪ್ರಯತ್ನಿಸಿ.',
    'server_error'          => 'Twitch ನಲ್ಲಿ ಸಮಸ್ಯೆ ಇದೆ. ನಂತರ ಮತ್ತೆ ಪ್ರಯತ್ನಿಸಿ.',
    'network'               => 'Twitch ಅನ್ನು ತಲುಪಲು ಸಾಧ್ಯವಾಗಲಿಲ್ಲ.',
    'error'                 => 'Twitch ದೋಷದೊಂದಿಗೆ ಪ್ರತಿಕ್ರಿಯಿಸಿದೆ.',
];
