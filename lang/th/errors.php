<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'โทเค็นการเข้าถึงของ Twitch ไม่ถูกต้องหรือหมดอายุแล้ว',
    'missing_scope'         => 'โทเค็นการเข้าถึงของ Twitch ขาดสิทธิ์ (scope): :scope',
    'app_token_required'    => 'จุดสิ้นสุดของ Twitch นี้รับเฉพาะโทเค็นการเข้าถึงของแอปเท่านั้น',
    'user_mismatch'         => 'ผู้ใช้ไม่ใช่เจ้าของโทเค็นการเข้าถึง',
    'client_mismatch'       => 'รหัสไคลเอนต์ของ Twitch ไม่ใช่รหัสที่สร้างทรัพยากรหรือโทเค็น',
    'no_organization'       => 'แอปพลิเคชัน Twitch ไม่ได้เชื่อมโยงกับองค์กร',
    'multiple_filters'      => 'Twitch รับตัวกรองเพียงหนึ่งรายการต่อครั้งเท่านั้น',
    'malformed_parameter'   => 'พารามิเตอร์ ":parameter" มีรูปแบบไม่ถูกต้อง',
    'bad_identifiers'       => 'ตัวระบุ Twitch (ID, ชื่อเข้าใช้) อย่างน้อยหนึ่งรายการไม่ถูกต้อง',
    'invalid_code'          => 'รหัสการให้สิทธิ์ของ Twitch ไม่ถูกต้องหรือหมดอายุแล้ว',
    'invalid_refresh_token' => 'โทเค็นการรีเฟรชของ Twitch ไม่ถูกต้อง: ผู้ใช้ต้องเข้าสู่ระบบอีกครั้ง',
    'bad_request'           => 'Twitch ปฏิเสธคำขอ',
    'unauthorized'          => 'Twitch ปฏิเสธข้อมูลรับรอง',
    'forbidden'             => 'ไม่อนุญาตให้ดำเนินการนี้สำหรับบัญชีหรือแอปพลิเคชันนี้',
    'not_found'             => 'Twitch ไม่พบสิ่งใดสำหรับคำขอนี้',
    'conflict'              => 'คำขอขัดแย้งกับสถานะปัจจุบันบน Twitch',
    'gone'                  => 'ฟีเจอร์นี้ของ Twitch ไม่พร้อมใช้งานอีกต่อไป',
    'unprocessable'         => 'Twitch ไม่สามารถประมวลผลคำขอได้',
    'rate_limited'          => 'Twitch ได้รับคำขอมากเกินไป โปรดลองอีกครั้งภายหลัง',
    'server_error'          => 'Twitch มีปัญหา โปรดลองอีกครั้งภายหลัง',
    'network'               => 'ไม่สามารถติดต่อ Twitch ได้',
    'error'                 => 'Twitch ตอบกลับด้วยข้อผิดพลาด',
];
