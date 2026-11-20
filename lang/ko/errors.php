<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch 액세스 토큰이 유효하지 않거나 만료되었습니다.',
    'missing_scope'         => 'Twitch 액세스 토큰에 권한(scope)이 없습니다: :scope.',
    'app_token_required'    => '이 Twitch 엔드포인트는 앱 액세스 토큰만 허용합니다.',
    'user_mismatch'         => '사용자가 액세스 토큰의 소유자가 아닙니다.',
    'client_mismatch'       => 'Twitch 클라이언트 ID가 리소스 또는 토큰을 만든 ID와 다릅니다.',
    'no_organization'       => 'Twitch 애플리케이션이 조직에 연결되어 있지 않습니다.',
    'multiple_filters'      => 'Twitch는 한 번에 하나의 필터만 허용합니다.',
    'malformed_parameter'   => '매개변수 ":parameter"의 형식이 올바르지 않습니다.',
    'bad_identifiers'       => '하나 이상의 Twitch 식별자(ID, 로그인)가 유효하지 않습니다.',
    'invalid_code'          => 'Twitch 인증 코드가 유효하지 않거나 만료되었습니다.',
    'invalid_refresh_token' => 'Twitch 갱신 토큰이 유효하지 않습니다. 사용자가 다시 로그인해야 합니다.',
    'bad_request'           => 'Twitch가 요청을 거부했습니다.',
    'unauthorized'          => 'Twitch가 자격 증명을 거부했습니다.',
    'forbidden'             => '이 계정 또는 이 애플리케이션에서는 이 작업이 허용되지 않습니다.',
    'not_found'             => 'Twitch에서 이 요청에 해당하는 항목을 찾지 못했습니다.',
    'conflict'              => '요청이 Twitch의 현재 상태와 충돌합니다.',
    'gone'                  => '이 Twitch 기능은 더 이상 사용할 수 없습니다.',
    'unprocessable'         => 'Twitch가 요청을 처리하지 못했습니다.',
    'rate_limited'          => 'Twitch가 너무 많은 요청을 받았습니다. 나중에 다시 시도하세요.',
    'server_error'          => 'Twitch에 문제가 있습니다. 나중에 다시 시도하세요.',
    'network'               => 'Twitch에 연결할 수 없습니다.',
    'error'                 => 'Twitch가 오류로 응답했습니다.',
];
