<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch 存取權杖無效或已過期。',
    'missing_scope'         => 'Twitch 存取權杖缺少權限 (scope)：:scope。',
    'app_token_required'    => '此 Twitch 端點只接受應用程式存取權杖。',
    'user_mismatch'         => '該使用者不是存取權杖的擁有者。',
    'client_mismatch'       => 'Twitch 用戶端 ID 不是建立該資源或權杖的用戶端 ID。',
    'no_organization'       => 'Twitch 應用程式未連結到任何組織。',
    'multiple_filters'      => 'Twitch 一次只接受一個篩選條件。',
    'malformed_parameter'   => '參數「:parameter」格式不正確。',
    'bad_identifiers'       => '一個或多個 Twitch 識別碼（ID、登入名稱）無效。',
    'invalid_code'          => 'Twitch 授權碼無效或已過期。',
    'invalid_refresh_token' => 'Twitch 重新整理權杖無效：使用者必須重新登入。',
    'bad_request'           => 'Twitch 拒絕了該請求。',
    'unauthorized'          => 'Twitch 拒絕了憑證。',
    'forbidden'             => '此帳號或此應用程式不允許執行該操作。',
    'not_found'             => 'Twitch 找不到與此請求相關的內容。',
    'conflict'              => '該請求與 Twitch 上的目前狀態衝突。',
    'gone'                  => '此 Twitch 功能已無法使用。',
    'unprocessable'         => 'Twitch 無法處理該請求。',
    'rate_limited'          => 'Twitch 收到的請求過多，請稍後再試。',
    'server_error'          => 'Twitch 發生問題，請稍後再試。',
    'network'               => '無法連線到 Twitch。',
    'error'                 => 'Twitch 回傳了錯誤。',
];
