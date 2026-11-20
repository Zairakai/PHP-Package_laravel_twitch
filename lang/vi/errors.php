<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Mã thông báo truy cập Twitch không hợp lệ hoặc đã hết hạn.',
    'missing_scope'         => 'Mã thông báo truy cập Twitch thiếu quyền (scope): :scope.',
    'app_token_required'    => 'Điểm cuối Twitch này chỉ chấp nhận mã thông báo truy cập của ứng dụng.',
    'user_mismatch'         => 'Người dùng không phải là chủ sở hữu của mã thông báo truy cập.',
    'client_mismatch'       => 'ID máy khách Twitch không phải là ID đã tạo tài nguyên hoặc mã thông báo.',
    'no_organization'       => 'Ứng dụng Twitch chưa được liên kết với tổ chức.',
    'multiple_filters'      => 'Twitch chỉ chấp nhận một bộ lọc mỗi lần.',
    'malformed_parameter'   => 'Tham số ":parameter" không đúng định dạng.',
    'bad_identifiers'       => 'Một hoặc nhiều định danh Twitch (ID, tên đăng nhập) không hợp lệ.',
    'invalid_code'          => 'Mã ủy quyền Twitch không hợp lệ hoặc đã hết hạn.',
    'invalid_refresh_token' => 'Mã thông báo làm mới Twitch không hợp lệ: người dùng phải đăng nhập lại.',
    'bad_request'           => 'Twitch đã từ chối yêu cầu.',
    'unauthorized'          => 'Twitch đã từ chối thông tin xác thực.',
    'forbidden'             => 'Hành động này không được phép đối với tài khoản hoặc ứng dụng này.',
    'not_found'             => 'Twitch không tìm thấy gì cho yêu cầu này.',
    'conflict'              => 'Yêu cầu xung đột với trạng thái hiện tại trên Twitch.',
    'gone'                  => 'Tính năng này của Twitch không còn khả dụng.',
    'unprocessable'         => 'Twitch không thể xử lý yêu cầu.',
    'rate_limited'          => 'Twitch nhận được quá nhiều yêu cầu. Hãy thử lại sau.',
    'server_error'          => 'Twitch đang gặp sự cố. Hãy thử lại sau.',
    'network'               => 'Không thể kết nối với Twitch.',
    'error'                 => 'Twitch đã phản hồi bằng một lỗi.',
];
