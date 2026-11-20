<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch ဝင်ရောက်ခွင့်တိုကင် မမှန်ကန်ပါ သို့မဟုတ် သက်တမ်းကုန်သွားပါပြီ။',
    'missing_scope'         => 'Twitch ဝင်ရောက်ခွင့်တိုကင်တွင် ခွင့်ပြုချက် (scope) မရှိပါ- :scope။',
    'app_token_required'    => 'ဤ Twitch endpoint သည် အက်ပ်ဝင်ရောက်ခွင့်တိုကင်ကိုသာ လက်ခံသည်။',
    'user_mismatch'         => 'အသုံးပြုသူသည် ဝင်ရောက်ခွင့်တိုကင်၏ပိုင်ရှင်မဟုတ်ပါ။',
    'client_mismatch'       => 'Twitch client ID သည် ရင်းမြစ် သို့မဟုတ် တိုကင်ကို ဖန်တီးခဲ့သူမဟုတ်ပါ။',
    'no_organization'       => 'Twitch အက်ပ်သည် အဖွဲ့အစည်းတစ်ခုနှင့် မချိတ်ဆက်ထားပါ။',
    'multiple_filters'      => 'Twitch သည် တစ်ကြိမ်လျှင် စစ်ထုတ်မှုတစ်ခုသာ လက်ခံသည်။',
    'malformed_parameter'   => 'ပါရာမီတာ ":parameter" ကို မှန်ကန်စွာ မဖွဲ့စည်းထားပါ။',
    'bad_identifiers'       => 'Twitch သတ်မှတ်စနစ် (ID၊ အကောင့်ဝင်အမည်) တစ်ခု သို့မဟုတ် တစ်ခုထက်ပိုသည် မမှန်ကန်ပါ။',
    'invalid_code'          => 'Twitch ခွင့်ပြုကုဒ် မမှန်ကန်ပါ သို့မဟုတ် သက်တမ်းကုန်သွားပါပြီ။',
    'invalid_refresh_token' => 'Twitch ပြန်လည်ဆန်းသစ်တိုကင် မမှန်ကန်ပါ- အသုံးပြုသူ ပြန်လည်ဝင်ရောက်ရမည်။',
    'bad_request'           => 'Twitch သည် တောင်းဆိုမှုကို ပယ်ချလိုက်သည်။',
    'unauthorized'          => 'Twitch သည် အထောက်အထားများကို ပယ်ချလိုက်သည်။',
    'forbidden'             => 'ဤအကောင့် သို့မဟုတ် အက်ပ်အတွက် ဤလုပ်ဆောင်ချက်ကို ခွင့်မပြုပါ။',
    'not_found'             => 'Twitch သည် ဤတောင်းဆိုမှုအတွက် မည်သည့်အရာမျှ မတွေ့ပါ။',
    'conflict'              => 'တောင်းဆိုမှုသည် Twitch ၏ လက်ရှိအခြေအနေနှင့် ဆန့်ကျင်နေသည်။',
    'gone'                  => 'ဤ Twitch လုပ်ဆောင်ချက်ကို မရရှိနိုင်တော့ပါ။',
    'unprocessable'         => 'Twitch သည် တောင်းဆိုမှုကို လုပ်ဆောင်၍မရပါ။',
    'rate_limited'          => 'Twitch သည် တောင်းဆိုမှုများစွာ လက်ခံရရှိသည်။ နောက်မှ ထပ်စမ်းကြည့်ပါ။',
    'server_error'          => 'Twitch တွင် ပြဿနာရှိနေသည်။ နောက်မှ ထပ်စမ်းကြည့်ပါ။',
    'network'               => 'Twitch ကို ဆက်သွယ်၍မရပါ။',
    'error'                 => 'Twitch သည် အမှားဖြင့် ပြန်ကြားသည်။',
];
