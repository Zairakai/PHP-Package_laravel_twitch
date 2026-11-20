<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch-ის წვდომის ტოკენი არასწორია ან ვადაგასულია.',
    'missing_scope'         => 'Twitch-ის წვდომის ტოკენს აკლია ნებართვა (scope): :scope.',
    'app_token_required'    => 'ეს Twitch-ის ბოლო წერტილი იღებს მხოლოდ აპლიკაციის წვდომის ტოკენს.',
    'user_mismatch'         => 'მომხმარებელი არ არის წვდომის ტოკენის მფლობელი.',
    'client_mismatch'       => 'Twitch-ის კლიენტის ID არ არის ის, რომელმაც შექმნა რესურსი ან ტოკენი.',
    'no_organization'       => 'Twitch-ის აპლიკაცია არ არის დაკავშირებული ორგანიზაციასთან.',
    'multiple_filters'      => 'Twitch ერთდროულად მხოლოდ ერთ ფილტრს იღებს.',
    'malformed_parameter'   => 'პარამეტრი „:parameter“ არასწორადაა ჩამოყალიბებული.',
    'bad_identifiers'       => 'Twitch-ის ერთი ან მეტი იდენტიფიკატორი (ID, ლოგინები) არასწორია.',
    'invalid_code'          => 'Twitch-ის ავტორიზაციის კოდი არასწორია ან ვადაგასულია.',
    'invalid_refresh_token' => 'Twitch-ის განახლების ტოკენი არასწორია: მომხმარებელმა ხელახლა უნდა შეიყვანოს.',
    'bad_request'           => 'Twitch-მა უარყო მოთხოვნა.',
    'unauthorized'          => 'Twitch-მა უარყო მონაცემები.',
    'forbidden'             => 'ეს მოქმედება დაუშვებელია ამ ანგარიშისთვის ან აპლიკაციისთვის.',
    'not_found'             => 'Twitch-მა ამ მოთხოვნისთვის ვერაფერი იპოვა.',
    'conflict'              => 'მოთხოვნა ეწინააღმდეგება Twitch-ის მიმდინარე მდგომარეობას.',
    'gone'                  => 'Twitch-ის ეს ფუნქცია აღარ არის ხელმისაწვდომი.',
    'unprocessable'         => 'Twitch-მა ვერ დაამუშავა მოთხოვნა.',
    'rate_limited'          => 'Twitch-მა ძალიან ბევრი მოთხოვნა მიიღო. სცადეთ მოგვიანებით.',
    'server_error'          => 'Twitch-ს პრობლემა აქვს. სცადეთ მოგვიანებით.',
    'network'               => 'Twitch-თან დაკავშირება ვერ მოხერხდა.',
    'error'                 => 'Twitch-მა შეცდომით უპასუხა.',
];
