<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch অ্যাক্সেস টোকেনটি অবৈধ বা মেয়াদ শেষ হয়ে গেছে।',
    'missing_scope'         => 'Twitch অ্যাক্সেস টোকেনে একটি অনুমতি (scope) নেই: :scope।',
    'app_token_required'    => 'এই Twitch এন্ডপয়েন্ট শুধুমাত্র অ্যাপ অ্যাক্সেস টোকেন গ্রহণ করে।',
    'user_mismatch'         => 'ব্যবহারকারী অ্যাক্সেস টোকেনের মালিক নন।',
    'client_mismatch'       => 'Twitch ক্লায়েন্ট ID সেটি নয় যা রিসোর্স বা টোকেন তৈরি করেছে।',
    'no_organization'       => 'Twitch অ্যাপ্লিকেশন কোনো প্রতিষ্ঠানের সাথে যুক্ত নয়।',
    'multiple_filters'      => 'Twitch একবারে শুধু একটি ফিল্টার গ্রহণ করে।',
    'malformed_parameter'   => '":parameter" প্যারামিটারটি সঠিকভাবে গঠিত নয়।',
    'bad_identifiers'       => 'এক বা একাধিক Twitch শনাক্তকারী (ID, লগইন) অবৈধ।',
    'invalid_code'          => 'Twitch অনুমোদন কোডটি অবৈধ বা মেয়াদ শেষ হয়ে গেছে।',
    'invalid_refresh_token' => 'Twitch রিফ্রেশ টোকেনটি অবৈধ: ব্যবহারকারীকে আবার লগইন করতে হবে।',
    'bad_request'           => 'Twitch অনুরোধ প্রত্যাখ্যান করেছে।',
    'unauthorized'          => 'Twitch পরিচয়পত্র প্রত্যাখ্যান করেছে।',
    'forbidden'             => 'এই অ্যাকাউন্ট বা অ্যাপ্লিকেশনের জন্য এই কাজ অনুমোদিত নয়।',
    'not_found'             => 'Twitch এই অনুরোধের জন্য কিছু খুঁজে পায়নি।',
    'conflict'              => 'অনুরোধটি Twitch-এর বর্তমান অবস্থার সাথে সাংঘর্ষিক।',
    'gone'                  => 'এই Twitch বৈশিষ্ট্যটি আর উপলব্ধ নেই।',
    'unprocessable'         => 'Twitch অনুরোধটি প্রক্রিয়া করতে পারেনি।',
    'rate_limited'          => 'Twitch অনেক বেশি অনুরোধ পেয়েছে। পরে আবার চেষ্টা করুন।',
    'server_error'          => 'Twitch-এ সমস্যা হচ্ছে। পরে আবার চেষ্টা করুন।',
    'network'               => 'Twitch-এর সাথে যোগাযোগ করা যায়নি।',
    'error'                 => 'Twitch একটি ত্রুটি দিয়ে সাড়া দিয়েছে।',
];
