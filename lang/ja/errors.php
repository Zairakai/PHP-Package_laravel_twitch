<?php

declare(strict_types=1);

// Errors of Twitch: the key is the `code` of TwitchError. :scope and :parameter are filled from the message of Twitch.
return [
    'token_invalid'         => 'Twitch のアクセストークンが無効か、期限切れです。',
    'missing_scope'         => 'Twitch のアクセストークンに権限 (scope) が不足しています: :scope。',
    'app_token_required'    => 'この Twitch のエンドポイントはアプリのアクセストークンのみ受け付けます。',
    'user_mismatch'         => 'ユーザーはアクセストークンの所有者ではありません。',
    'client_mismatch'       => 'Twitch のクライアント ID が、リソースまたはトークンを作成したものと一致しません。',
    'no_organization'       => 'Twitch アプリケーションが組織に関連付けられていません。',
    'multiple_filters'      => 'Twitch は一度に 1 つのフィルターのみ受け付けます。',
    'malformed_parameter'   => 'パラメーター「:parameter」の形式が正しくありません。',
    'bad_identifiers'       => 'Twitch の識別子 (ID、ログイン名) が 1 つ以上無効です。',
    'invalid_code'          => 'Twitch の認可コードが無効か、期限切れです。',
    'invalid_refresh_token' => 'Twitch のリフレッシュトークンが無効です。ユーザーは再度ログインする必要があります。',
    'bad_request'           => 'Twitch はリクエストを拒否しました。',
    'unauthorized'          => 'Twitch は認証情報を拒否しました。',
    'forbidden'             => 'このアカウントまたはアプリケーションではこの操作は許可されていません。',
    'not_found'             => 'Twitch でこのリクエストに該当するものが見つかりませんでした。',
    'conflict'              => 'リクエストが Twitch 上の現在の状態と競合しています。',
    'gone'                  => 'この Twitch の機能はもう利用できません。',
    'unprocessable'         => 'Twitch はリクエストを処理できませんでした。',
    'rate_limited'          => 'Twitch へのリクエストが多すぎます。しばらくしてからもう一度お試しください。',
    'server_error'          => 'Twitch に問題が発生しています。しばらくしてからもう一度お試しください。',
    'network'               => 'Twitch に接続できませんでした。',
    'error'                 => 'Twitch がエラーを返しました。',
];
