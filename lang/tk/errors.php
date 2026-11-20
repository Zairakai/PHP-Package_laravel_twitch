<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch giriş tokeni nädogry ýa-da möhleti gutardy.',
    'missing_scope'         => 'Twitch giriş tokeninde rugsat (scope) ýok: :scope.',
    'app_token_required'    => 'Bu Twitch soňky nokady diňe programmanyň giriş tokenini kabul edýär.',
    'user_mismatch'         => 'Ulanyjy giriş tokeniniň eýesi däl.',
    'client_mismatch'       => 'Twitch müşderi ID-si serişdäni ýa-da tokeni döreden ID däl.',
    'no_organization'       => 'Twitch programmasy guramaga baglanmadyk.',
    'multiple_filters'      => 'Twitch bir wagtda diňe bir süzgüji kabul edýär.',
    'malformed_parameter'   => '":parameter" parametri nädogry düzülen.',
    'bad_identifiers'       => 'Twitch kesgitleýjileriniň biri ýa-da birnäçesi (ID, giriş atlary) nädogry.',
    'invalid_code'          => 'Twitch rugsat koduny nädogry ýa-da möhleti gutardy.',
    'invalid_refresh_token' => 'Twitch täzeleme tokeni nädogry: ulanyjy täzeden girmeli.',
    'bad_request'           => 'Twitch haýyşy ret etdi.',
    'unauthorized'          => 'Twitch ygtyýarnamalary ret etdi.',
    'forbidden'             => 'Bu hereket bu hasap ýa-da programma üçin rugsat berilmeýär.',
    'not_found'             => 'Twitch bu haýyş üçin hiç zat tapmady.',
    'conflict'              => 'Haýyş Twitch-iň häzirki ýagdaýy bilen gapma-garşy gelýär.',
    'gone'                  => 'Twitch-iň bu aýratynlygy indi elýeterli däl.',
    'unprocessable'         => 'Twitch haýyşy işläp bilmedi.',
    'rate_limited'          => 'Twitch gaty köp haýyş aldy. Soňrak täzeden synanyşyň.',
    'server_error'          => 'Twitch-de problema bar. Soňrak täzeden synanyşyň.',
    'network'               => 'Twitch bilen aragatnaşyk gurmak başartmady.',
    'error'                 => 'Twitch ýalňyşlyk bilen jogap berdi.',
];
