<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'אסימון הגישה של Twitch אינו תקין או שפג תוקפו.',
    'missing_scope'         => 'לאסימון הגישה של Twitch חסרה הרשאה (scope): :scope.',
    'app_token_required'    => 'נקודת הקצה הזו של Twitch מקבלת רק אסימון גישה של אפליקציה.',
    'user_mismatch'         => 'המשתמש אינו הבעלים של אסימון הגישה.',
    'client_mismatch'       => 'מזהה הלקוח של Twitch אינו זה שיצר את המשאב או את האסימון.',
    'no_organization'       => 'אפליקציית Twitch אינה מקושרת לארגון.',
    'multiple_filters'      => 'Twitch מקבלת רק מסנן אחד בכל פעם.',
    'malformed_parameter'   => 'הפרמטר ":parameter" אינו בנוי כראוי.',
    'bad_identifiers'       => 'מזהה אחד או יותר של Twitch (מזהים, שמות משתמש) אינם תקינים.',
    'invalid_code'          => 'קוד ההרשאה של Twitch אינו תקין או שפג תוקפו.',
    'invalid_refresh_token' => 'אסימון הרענון של Twitch אינו תקין: על המשתמש להתחבר מחדש.',
    'bad_request'           => 'Twitch דחתה את הבקשה.',
    'unauthorized'          => 'Twitch דחתה את פרטי ההזדהות.',
    'forbidden'             => 'פעולה זו אינה מותרת עבור חשבון או אפליקציה זו.',
    'not_found'             => 'Twitch לא מצאה דבר עבור בקשה זו.',
    'conflict'              => 'הבקשה מתנגשת עם המצב הנוכחי ב-Twitch.',
    'gone'                  => 'תכונה זו של Twitch אינה זמינה עוד.',
    'unprocessable'         => 'Twitch לא הצליחה לעבד את הבקשה.',
    'rate_limited'          => 'Twitch קיבלה יותר מדי בקשות. נסו שוב מאוחר יותר.',
    'server_error'          => 'ל-Twitch יש בעיה. נסו שוב מאוחר יותר.',
    'network'               => 'לא ניתן היה ליצור קשר עם Twitch.',
    'error'                 => 'Twitch השיבה בשגיאה.',
];
