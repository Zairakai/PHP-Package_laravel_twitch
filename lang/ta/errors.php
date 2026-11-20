<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch அணுகல் டோக்கன் செல்லாதது அல்லது காலாவதியாகிவிட்டது.',
    'missing_scope'         => 'Twitch அணுகல் டோக்கனில் அனுமதி (scope) இல்லை: :scope.',
    'app_token_required'    => 'இந்த Twitch எண்ட்பாயின்ட் ஆப் அணுகல் டோக்கனை மட்டுமே ஏற்கிறது.',
    'user_mismatch'         => 'பயனர் அணுகல் டோக்கனின் உரிமையாளர் அல்ல.',
    'client_mismatch'       => 'Twitch கிளையன்ட் ID என்பது வளத்தை அல்லது டோக்கனை உருவாக்கியது அல்ல.',
    'no_organization'       => 'Twitch பயன்பாடு எந்த நிறுவனத்துடனும் இணைக்கப்படவில்லை.',
    'multiple_filters'      => 'Twitch ஒரே நேரத்தில் ஒரு வடிகட்டியை மட்டுமே ஏற்கிறது.',
    'malformed_parameter'   => '":parameter" அளவுரு சரியாக உருவாக்கப்படவில்லை.',
    'bad_identifiers'       => 'ஒன்று அல்லது அதற்கு மேற்பட்ட Twitch அடையாளங்காட்டிகள் (ID, உள்நுழைவுகள்) செல்லாதவை.',
    'invalid_code'          => 'Twitch அங்கீகாரக் குறியீடு செல்லாதது அல்லது காலாவதியாகிவிட்டது.',
    'invalid_refresh_token' => 'Twitch புதுப்பிப்பு டோக்கன் செல்லாதது: பயனர் மீண்டும் உள்நுழைய வேண்டும்.',
    'bad_request'           => 'Twitch கோரிக்கையை நிராகரித்தது.',
    'unauthorized'          => 'Twitch சான்றுகளை நிராகரித்தது.',
    'forbidden'             => 'இந்தக் கணக்கு அல்லது பயன்பாட்டிற்கு இந்தச் செயல் அனுமதிக்கப்படவில்லை.',
    'not_found'             => 'இந்தக் கோரிக்கைக்கு Twitch எதையும் கண்டறியவில்லை.',
    'conflict'              => 'கோரிக்கை Twitch இன் தற்போதைய நிலையுடன் முரண்படுகிறது.',
    'gone'                  => 'இந்த Twitch அம்சம் இனி கிடைக்காது.',
    'unprocessable'         => 'Twitch ஆல் கோரிக்கையைச் செயலாக்க முடியவில்லை.',
    'rate_limited'          => 'Twitch க்கு அதிகமான கோரிக்கைகள் கிடைத்தன. பின்னர் மீண்டும் முயலவும்.',
    'server_error'          => 'Twitch இல் சிக்கல் உள்ளது. பின்னர் மீண்டும் முயலவும்.',
    'network'               => 'Twitch ஐ அடைய முடியவில்லை.',
    'error'                 => 'Twitch பிழையுடன் பதிலளித்தது.',
];
