<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'ໂທເຄັນການເຂົ້າເຖິງ Twitch ບໍ່ຖືກຕ້ອງ ຫຼື ໝົດອາຍຸແລ້ວ.',
    'missing_scope'         => 'ໂທເຄັນການເຂົ້າເຖິງ Twitch ຂາດສິດ (scope): :scope.',
    'app_token_required'    => 'ຈຸດສິ້ນສຸດ Twitch ນີ້ຮັບສະເພາະໂທເຄັນການເຂົ້າເຖິງຂອງແອັບເທົ່ານັ້ນ.',
    'user_mismatch'         => 'ຜູ້ໃຊ້ບໍ່ແມ່ນເຈົ້າຂອງໂທເຄັນການເຂົ້າເຖິງ.',
    'client_mismatch'       => 'ID ລູກຄ້າ Twitch ບໍ່ແມ່ນອັນທີ່ສ້າງຊັບພະຍາກອນ ຫຼື ໂທເຄັນ.',
    'no_organization'       => 'ແອັບ Twitch ບໍ່ໄດ້ເຊື່ອມຕໍ່ກັບອົງກອນ.',
    'multiple_filters'      => 'Twitch ຮັບພຽງຕົວກັ່ນຕອງດຽວຕໍ່ເທື່ອ.',
    'malformed_parameter'   => 'ພາຣາມິເຕີ ":parameter" ບໍ່ຖືກຕ້ອງ.',
    'bad_identifiers'       => 'ຕົວລະບຸ Twitch ໜຶ່ງ ຫຼື ຫຼາຍອັນ (ID, ຊື່ເຂົ້າສູ່ລະບົບ) ບໍ່ຖືກຕ້ອງ.',
    'invalid_code'          => 'ລະຫັດການອະນຸຍາດ Twitch ບໍ່ຖືກຕ້ອງ ຫຼື ໝົດອາຍຸແລ້ວ.',
    'invalid_refresh_token' => 'ໂທເຄັນການຣີເຟຣຊ Twitch ບໍ່ຖືກຕ້ອງ: ຜູ້ໃຊ້ຕ້ອງເຂົ້າສູ່ລະບົບຄືນໃໝ່.',
    'bad_request'           => 'Twitch ປະຕິເສດຄຳຮ້ອງ.',
    'unauthorized'          => 'Twitch ປະຕິເສດຂໍ້ມູນຢືນຢັນຕົວຕົນ.',
    'forbidden'             => 'ການກະທຳນີ້ບໍ່ໄດ້ຮັບອະນຸຍາດສຳລັບບັນຊີ ຫຼື ແອັບນີ້.',
    'not_found'             => 'Twitch ບໍ່ພົບຫຍັງສຳລັບຄຳຮ້ອງນີ້.',
    'conflict'              => 'ຄຳຮ້ອງຂັດກັບສະຖານະປັດຈຸບັນຢູ່ Twitch.',
    'gone'                  => 'ຄຸນສົມບັດ Twitch ນີ້ບໍ່ມີອີກແລ້ວ.',
    'unprocessable'         => 'Twitch ບໍ່ສາມາດປະມວນຜົນຄຳຮ້ອງໄດ້.',
    'rate_limited'          => 'Twitch ໄດ້ຮັບຄຳຮ້ອງຫຼາຍເກີນໄປ. ກະລຸນາລອງໃໝ່ພາຍຫຼັງ.',
    'server_error'          => 'Twitch ມີບັນຫາ. ກະລຸນາລອງໃໝ່ພາຍຫຼັງ.',
    'network'               => 'ບໍ່ສາມາດຕິດຕໍ່ Twitch ໄດ້.',
    'error'                 => 'Twitch ຕອບກັບດ້ວຍຂໍ້ຜິດພາດ.',
];
