<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch хандалтын токен хүчингүй эсвэл хугацаа нь дууссан.',
    'missing_scope'         => 'Twitch хандалтын токенд зөвшөөрөл (scope) байхгүй: :scope.',
    'app_token_required'    => 'Энэ Twitch төгсгөлийн цэг зөвхөн аппликейшний хандалтын токеныг хүлээн авдаг.',
    'user_mismatch'         => 'Хэрэглэгч нь хандалтын токены эзэмшигч биш.',
    'client_mismatch'       => 'Twitch клиент ID нь нөөц эсвэл токеныг үүсгэсэн ID биш.',
    'no_organization'       => 'Twitch аппликейшн байгууллагатай холбогдоогүй байна.',
    'multiple_filters'      => 'Twitch нэг дор зөвхөн нэг шүүлтүүр хүлээн авдаг.',
    'malformed_parameter'   => '«:parameter» параметр буруу бүтэцтэй байна.',
    'bad_identifiers'       => 'Twitch-ийн нэг буюу хэд хэдэн танигч (ID, нэвтрэх нэр) хүчингүй байна.',
    'invalid_code'          => 'Twitch зөвшөөрлийн код хүчингүй эсвэл хугацаа нь дууссан.',
    'invalid_refresh_token' => 'Twitch шинэчлэх токен хүчингүй: хэрэглэгч дахин нэвтрэх шаардлагатай.',
    'bad_request'           => 'Twitch хүсэлтийг татгалзлаа.',
    'unauthorized'          => 'Twitch нэвтрэх мэдээллийг татгалзлаа.',
    'forbidden'             => 'Энэ үйлдлийг энэ бүртгэл эсвэл аппликейшнд зөвшөөрөөгүй.',
    'not_found'             => 'Twitch энэ хүсэлтэд юу ч олсонгүй.',
    'conflict'              => 'Хүсэлт Twitch дээрх одоогийн төлөвтэй зөрчилдөж байна.',
    'gone'                  => 'Twitch-ийн энэ боломж цаашид байхгүй.',
    'unprocessable'         => 'Twitch хүсэлтийг боловсруулж чадсангүй.',
    'rate_limited'          => 'Twitch хэт олон хүсэлт хүлээн авлаа. Дараа дахин оролдоно уу.',
    'server_error'          => 'Twitch-д асуудал гарлаа. Дараа дахин оролдоно уу.',
    'network'               => 'Twitch-тэй холбогдож чадсангүй.',
    'error'                 => 'Twitch алдаагаар хариулав.',
];
