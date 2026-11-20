<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch 访问令牌无效或已过期。',
    'missing_scope'         => 'Twitch 访问令牌缺少权限 (scope)：:scope。',
    'app_token_required'    => '此 Twitch 端点只接受应用访问令牌。',
    'user_mismatch'         => '该用户不是访问令牌的所有者。',
    'client_mismatch'       => 'Twitch 客户端 ID 不是创建该资源或令牌的客户端 ID。',
    'no_organization'       => 'Twitch 应用程序未关联到任何组织。',
    'multiple_filters'      => 'Twitch 一次只接受一个筛选条件。',
    'malformed_parameter'   => '参数“:parameter”格式不正确。',
    'bad_identifiers'       => '一个或多个 Twitch 标识符（ID、登录名）无效。',
    'invalid_code'          => 'Twitch 授权码无效或已过期。',
    'invalid_refresh_token' => 'Twitch 刷新令牌无效：用户必须重新登录。',
    'bad_request'           => 'Twitch 拒绝了该请求。',
    'unauthorized'          => 'Twitch 拒绝了凭据。',
    'forbidden'             => '此账户或此应用程序不允许执行该操作。',
    'not_found'             => 'Twitch 未找到与此请求相关的内容。',
    'conflict'              => '该请求与 Twitch 上的当前状态冲突。',
    'gone'                  => '此 Twitch 功能已不可用。',
    'unprocessable'         => 'Twitch 无法处理该请求。',
    'rate_limited'          => 'Twitch 收到的请求过多，请稍后重试。',
    'server_error'          => 'Twitch 出现问题，请稍后重试。',
    'network'               => '无法连接到 Twitch。',
    'error'                 => 'Twitch 返回了错误。',
];
