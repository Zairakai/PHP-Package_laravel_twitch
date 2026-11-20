<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch ৰ এক্সেছ টকেন অবৈধ বা ম্যাদ উকলি গৈছে।',
    'missing_scope'         => 'Twitch ৰ এক্সেছ টকেনত এটা অনুমতি (scope) নাই: :scope।',
    'app_token_required'    => 'এই Twitch এণ্ডপইণ্টে কেৱল এপ্‌ এক্সেছ টকেন গ্ৰহণ কৰে।',
    'user_mismatch'         => 'ব্যৱহাৰকাৰী এক্সেছ টকেনৰ গৰাকী নহয়।',
    'client_mismatch'       => 'Twitch ক্লায়েণ্ট ID সম্পদ বা টকেন সৃষ্টি কৰাজন নহয়।',
    'no_organization'       => 'Twitch এপ্লিকেচন কোনো সংস্থাৰ লগত সংযুক্ত নহয়।',
    'multiple_filters'      => 'Twitch এ এক সময়ত কেৱল এটা ফিল্টাৰ গ্ৰহণ কৰে।',
    'malformed_parameter'   => 'পেৰামিটাৰ ":parameter" ভুলকৈ গঠিত।',
    'bad_identifiers'       => 'এটা বা অধিক Twitch চিনাক্তকাৰী (ID, লগইন) অবৈধ।',
    'invalid_code'          => 'Twitch ৰ অনুমোদন ক\'ড অবৈধ বা ম্যাদ উকলি গৈছে।',
    'invalid_refresh_token' => 'Twitch ৰ ৰিফ্ৰেচ টকেন অবৈধ: ব্যৱহাৰকাৰীয়ে পুনৰ লগ ইন কৰিব লাগিব।',
    'bad_request'           => 'Twitch এ অনুৰোধ অস্বীকাৰ কৰিলে।',
    'unauthorized'          => 'Twitch এ প্ৰমাণপত্ৰ অস্বীকাৰ কৰিলে।',
    'forbidden'             => 'এই একাউণ্ট বা এপ্লিকেচনৰ বাবে এই কাৰ্য অনুমোদিত নহয়।',
    'not_found'             => 'Twitch এ এই অনুৰোধৰ বাবে একো বিচাৰি নাপালে।',
    'conflict'              => 'অনুৰোধটো Twitch ৰ বৰ্তমান অৱস্থাৰ সৈতে সংঘাত কৰিছে।',
    'gone'                  => 'এই Twitch বৈশিষ্ট্য আৰু উপলব্ধ নহয়।',
    'unprocessable'         => 'Twitch এ অনুৰোধ প্ৰক্ৰিয়া কৰিব নোৱাৰিলে।',
    'rate_limited'          => 'Twitch এ অতি বেছি অনুৰোধ পালে। পিছত পুনৰ চেষ্টা কৰক।',
    'server_error'          => 'Twitch ত সমস্যা হৈছে। পিছত পুনৰ চেষ্টা কৰক।',
    'network'               => 'Twitch ৰ লগত যোগাযোগ কৰিব পৰা নগ\'ল।',
    'error'                 => 'Twitch এ ত্ৰুটিৰে উত্তৰ দিলে।',
];
